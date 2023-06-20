<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Entity\Order;
use App\Form\MealType;
use App\Repository\MealRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealController extends AbstractController
{
    public function __construct(
        private readonly MealRepository $mealRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/meal/new', name: 'meal_new')]
    public function new(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $meal = new Meal();

        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $meal->setChef($this->getUser());
            $meal->setRemainingShares($meal->getShares());
            if (!$form->get('image')->getData()) {
                $meal->setImage('https://picsum.photos/200');
            }

            $this->entityManager->persist($meal);
            $this->entityManager->flush();

            return $this->redirectToRoute('meal_show', ['id' => $meal->getId()]);
        }

        return $this->render('meal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/meal/{id}', name: 'meal_show')]
    public function show(int $id): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $meal = $this->mealRepository->find($id);

        if (!$meal) {
            $this->addFlash('danger', 'Ce plat n\'existe pas');

            return $this->redirectToRoute('app_home');
        }

        $userOrder = $this->entityManager->getRepository(Order::class)->findOneBy([
            'meal' => $meal,
            'customer' => $user,
        ]);

        return $this->render('meal/show.html.twig', [
            'meal' => $meal,
            'userOrder' => $userOrder,
        ]);
    }

    #[Route('/meal/{id}/order', name: 'meal_order')]
    public function order(Meal $meal): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if ($meal->getChef() === $this->getUser()) {
            $this->addFlash('danger', 'Vous ne pouvez pas commander votre propre plat.');
            return $this->redirectToRoute('meal_show', ['id' => $meal->getId()]);
        }

        if ($meal->getRemainingShares() <= 0) {
            $this->addFlash('danger', 'Ce plat n\'a plus de part disponible.');
            return $this->redirectToRoute('meal_show', ['id' => $meal->getId()]);
        }

        $meal->setRemainingShares($meal->getRemainingShares() - 1);

        $this->entityManager->persist($meal);

        $order = new Order();
        $order->setMeal($meal);
        $order->setCustomer($this->getUser());

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->addFlash('success', 'Votre commande a bien été enregistrée.');

        return $this->redirectToRoute('meal_show', ['id' => $meal->getId()]);
    }

    #[Route('/meal/{id}/order-cancel', name: 'meal_cancel_order')]
    public function cancelOrder(Order $order): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $meal = $order->getMeal();

        if ($meal->getRemainingShares() <= 0) {
            $this->addFlash('danger', 'Ce plat n\'a plus de part disponible.');
            return $this->redirectToRoute('meal_show', ['id' => $meal->getId()]);
        }

        if ($meal->getRemainingShares() >= $meal->getShares()) {
            $this->addFlash('danger', 'Il n\'y a pas eu de commande de part pour ce plat.');
            return $this->redirectToRoute('meal_show', ['id' => $meal->getId()]);
        }

        $meal->setRemainingShares($meal->getRemainingShares() + 1);

        $this->entityManager->remove($order);

        $this->entityManager->persist($meal);

        $this->entityManager->flush();

        $this->addFlash('success', 'Votre commande a bien été annulée.');

        return $this->redirectToRoute('meal_show', ['id' => $meal->getId()]);
    }

}
