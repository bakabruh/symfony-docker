<?php

namespace App\Controller;

use App\Repository\MealRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly MealRepository $mealRepository,
        private readonly OrderRepository $orderRepository,
        private readonly UserRepository $userRepository,
    )
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $meals = $this->mealRepository->findAll();

        return $this->render('home/index.html.twig', [
            'meals' => $meals,
        ]);
    }

    #[Route('/info', name: 'app_info')]
    public function info(): Response
    {
        $meals = $this->mealRepository->findAll();
        $orders = $this->orderRepository->findAll();
        $users = $this->userRepository->findAll();

        return $this->render('home/info.html.twig', [
            'meals' => $meals,
            'orders' => $orders,
            'users' => $users,
        ]);
    }
}
