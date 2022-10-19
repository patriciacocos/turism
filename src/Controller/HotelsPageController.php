<?php

namespace App\Controller;

use App\DoctrineRepositoryGetter;
use App\Entity\Cazare;
use App\Entity\RezervareCazare;
use App\Entity\RezervareObiective;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class HotelsPageController extends AbstractController
{
    public function __construct(
        private readonly DoctrineRepositoryGetter $doctrineRepositoryGetter,
        private readonly EntityManagerInterface $entityManager,
    ) {

    }
    #[Route(
        path: '/hotel',
        name: 'app_hotels_page',
    )]
    public function index(): Response
    {
        $hotelRepository = $this->doctrineRepositoryGetter->getRepository(Cazare::class );
        $hotels = $hotelRepository->findAll();

        return $this->render('hotels/hotels.html.twig', [
            'hotel' => $hotels
        ]);
    }

    #[Route(
        path: '/account/hotel/{hotel}/rezervare',
        name: 'app_hotel_reservation_page',
        requirements: [
            'hotel' => '\d+'
        ]
    )]
    public function reservation(int $hotel, Request $request ): Response
    {
        $hotelRepository= $this->doctrineRepositoryGetter->getRepository(Cazare::class );
        $hotel = $hotelRepository->find($hotel);

        $reservation = new RezervareCazare();
        $reservation->setDataSosire(new \DateTime('now'));
        $reservation->setDataPlecare(new \DateTime('tomorrow'));
        $reservation->setIdCazare($hotel);
        if($this->getUser())
        {
            $reservation->setIdUser($this->getUser());
        }

        $form = $this->createFormBuilder($reservation)
            ->add('numeUser', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message'=>'Trebuie sa introduceti un nume.'
                    ]),
                    new Regex('/\w+\s\w+/', 'Trebuie sa introduceti un nume si prenume.')
                ] ,
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Introdu numele complet'
                ]
            ])
            ->add('nrCamere', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message'=>'Trebuie sa introduceti un numar de camere.'
                    ]),
                    new Regex('/\d+/', 'Trebuie sa introduceti un numar.'),

                ],
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Introdu numarul de camere'
                ]
            ])

            ->add('dataSosire', DateType::class, [
                'constraints' => [
                   new GreaterThanOrEqual(new \DateTime('yesterday'),null, 'Data sosire trebuie sa fie cel putin data de astazi.')
                ],
                'attr'=>[
                    'class'=>'form-control',
                    'type'=>'date'
                ]
            ])

            ->add('dataPlecare', DateType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(new \DateTime('now'),null, 'Data plecare trebuie sa fie cel putin ziua de maine.')
                ],
                'attr'=>[
                    'class'=>'form-control',
                    'type'=>'date'
                ],
            ])

            ->add('rezerva',SubmitType::class, [
                'attr'=>[
                    'class'=>'submit-btn'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();

            return $this->render('reservation/hotelReservation.html.twig', [
                'hotel' => $hotel,
                'form'=> $form->createView(),
                'success'=>'Rezervarea a fost facuta'
            ]);
        }


        return $this->render('reservation/hotelReservation.html.twig', [
            'hotel' => $hotel,
            'form'=> $form->createView()
        ]);
    }
}
