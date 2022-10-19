<?php

namespace App\Controller;

use App\DoctrineRepositoryGetter;
use App\Entity\Arta;
use App\Entity\Cazare;
use App\Entity\MancareBautura;
use App\Entity\MonumenteIstorice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    public function __construct(
        private readonly DoctrineRepositoryGetter $doctrineRepositoryGetter,
        private readonly EntityManagerInterface $entityManager,
    ) {

    }

    #[Route(
        path: '/',
        name: 'app_home_page',
    )]
    public function index(): Response
    {
        $monumentRepository = $this->doctrineRepositoryGetter->getRepository(MonumenteIstorice::class );
        $topLikedMonumentsData= $monumentRepository->getMostLikedMonuments();
        $topLikedMonuments=[];
        foreach ( $topLikedMonumentsData as $topLikedMonumentsDatum )
        {
            $topLikedMonuments[]=$monumentRepository->find($topLikedMonumentsDatum['idMonumenteIstorice']);
        }

        $artaRepository = $this->doctrineRepositoryGetter->getRepository(Arta::class );
        $topLikedArtData= $artaRepository->getMostLikedArt();
        $topLikedArt=[];
        foreach ( $topLikedArtData as $topLikedArtDatum )
        {
            $topLikedArt[]=$artaRepository->find($topLikedArtDatum['idArta']);
        }

        $hotelRepository = $this->doctrineRepositoryGetter->getRepository(Cazare::class );
        $topLikedHotelsData= $hotelRepository->getMostLikedHotels();
        $topLikedHotels=[];
        foreach ( $topLikedHotelsData as $topLikedHotelsDatum )
        {
            $topLikedHotels[]=$hotelRepository->find($topLikedHotelsDatum['idCazare']);
        }

        $restaurantRepository = $this->doctrineRepositoryGetter->getRepository(MancareBautura::class );
        $topLikedRestaurantsData= $restaurantRepository->getMostLikedRestaurants();
        $topLikedRestaurants=[];
        foreach ( $topLikedRestaurantsData as $topLikedRestaurantsDatum )
        {
            $topLikedRestaurants[]=$restaurantRepository->find($topLikedRestaurantsDatum['idMancareBautura']);
        }

        return $this->render('home/index.html.twig', [
            'topLikedMonuments'=> $topLikedMonuments,
            'topLikedArt'=>$topLikedArt,
            'topLikedHotels'=>$topLikedHotels,
            'topLikedRestaurants'=>$topLikedRestaurants
        ]);
    }

}
