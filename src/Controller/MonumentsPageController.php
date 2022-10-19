<?php

namespace App\Controller;

use App\DoctrineRepositoryGetter;
use App\Entity\Favorite;
use App\Entity\MonumenteIstorice;
use App\Entity\RezervareObiective;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class MonumentsPageController extends AbstractController
{
    public function __construct(
        private readonly DoctrineRepositoryGetter $doctrineRepositoryGetter,
        private readonly EntityManagerInterface $entityManager,
    ) {

    }

    #[Route(
        path: '/monumente',
        name: 'app_monuments_page',
    )]
    public function index(): Response
    {
        $monumentRepository = $this->doctrineRepositoryGetter->getRepository(MonumenteIstorice::class );
        $monuments = $monumentRepository->findAll();

        return $this->render('monuments/monumente.html.twig', [
            'monuments' => $monuments
        ]);
    }

    #[Route(
        path: '/account/monument/{monument}/rezervare',
        name: 'app_monument_reservation_page',
        requirements: [
            'monument' => '\d+'
        ]
    )]
    public function reservation(int $monument, Request $request ): Response
    {
        $monumentRepository = $this->doctrineRepositoryGetter->getRepository(MonumenteIstorice::class );
        $monument = $monumentRepository->find($monument);

        $reservation = new RezervareObiective();
        $reservation->setIdMonument($monument);
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
            ->add('nrLocuri', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message'=>'Trebuie sa introduceti un numar de locuri.'
                    ]),
                    new Regex('/\d+/', 'Trebuie sa introduceti un numar.'),

                ],
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('oraRezervarii', TimeType::class, [
                'constraints' => [
                    new NotBlank([
                        'message'=>'Trebuie sa introduceti o ora.'
                    ])
                ],
                'attr'=>[
                    'class'=>'form-control',
                    'type'=>'time'
                ]
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

            return $this->render('monument/reservation.html.twig', [
                'monument' => $monument,
                'form'=> $form->createView(),
                'success'=>'Rezervarea a fost facuta'
            ]);
        }


        return $this->render('monument/reservation.html.twig', [
            'monument' => $monument,
            'form'=> $form->createView()
        ]);
    }
}
