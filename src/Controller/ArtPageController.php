<?php

namespace App\Controller;

use App\DoctrineRepositoryGetter;
use App\Entity\Arta;
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

class ArtPageController extends AbstractController
{
    public function __construct(
        private readonly DoctrineRepositoryGetter $doctrineRepositoryGetter,
        private readonly EntityManagerInterface $entityManager,
    ) {

    }
    #[Route(
        path: '/arta',
        name: 'app_art_page',
    )]
    public function index(): Response
    {
        $artaRepository = $this->doctrineRepositoryGetter->getRepository(Arta::class );
        $artObjects = $artaRepository->findAll();

        return $this->render('art/art.html.twig', [
            'artObjects' => $artObjects
        ]);
    }


    #[Route(
        path: '/account/arta/{art}/rezervare',
        name: 'app_art_reservation_page',
        requirements: [
            'art' => '\d+'
        ]
    )]
    public function reservation(int $art, Request $request ): Response
    {
        $artRepository= $this->doctrineRepositoryGetter->getRepository(Arta::class );
        $art = $artRepository->find($art);

        $reservation = new RezervareObiective();
        $reservation->setIdArta($art);
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

            return $this->render('art reservation/reservation.html.twig', [
                'art' => $art,
                'form'=> $form->createView(),
                'success'=>'Rezervarea a fost facuta'
            ]);
        }


        return $this->render('art reservation/reservation.html.twig', [
            'art' => $art,
            'form'=> $form->createView()
        ]);
    }
}
