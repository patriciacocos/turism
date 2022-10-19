<?php

namespace App\Controller;

use App\DoctrineRepositoryGetter;
use App\Entity\Arta;
use App\Entity\MancareBautura;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantPageController extends AbstractController
{
    public function __construct(
        private readonly DoctrineRepositoryGetter $doctrineRepositoryGetter,
        private readonly EntityManagerInterface $entityManager,
    ) {

    }
    #[Route(
        path: '/restaurant',
        name: 'app_restaurant_page',
    )]
    public function index(): Response
    {
        $restaurantRepository = $this->doctrineRepositoryGetter->getRepository(MancareBautura::class );
        $restaurant = $restaurantRepository->findAll();

        return $this->render('restaurant/restaurant.html.twig', [
            'restaurant' => $restaurant
        ]);
    }
}
