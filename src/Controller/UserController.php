<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }

    #[Route('/user/me', name: 'app_user_me')]
    public function profile(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à votre profil.');
            return $this->redirectToRoute('app_login');
        }

        $orders = $this->orderRepository->findBy(['customer' => $user]);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_show')]
    public function show(User $user): Response
    {
        if (!$user) {
            $this->addFlash('error', 'Aucun utilisateur trouvé.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
