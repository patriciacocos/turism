<?php
namespace App\Controller;

use App\DoctrineRepositoryGetter;
use App\Entity\Favorite;
use App\Entity\RezervareCazare;
use App\Entity\RezervareObiective;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index_html.twig', array(
            'error' => $error,
            'username' => $lastUsername,
        ));
    }

    /**
     * @Route("/profile", name="app_profile")
     */
    public function profile(DoctrineRepositoryGetter $doctrineRepositoryGetter)
    {
        $favoriteRepository= $doctrineRepositoryGetter->getRepository(Favorite::class);
        $favorites= $favoriteRepository->findBy([
            'idUser'=>$this->getUser()
        ]);

        $reservationRepository= $doctrineRepositoryGetter->getRepository(RezervareObiective::class);
        $reservations= $reservationRepository->findBy([
            'idUser'=>$this->getUser()
        ]);

        $reservationCazareRepository= $doctrineRepositoryGetter->getRepository(RezervareCazare::class);
        $reservationsHotels= $reservationCazareRepository->findBy([
            'idUser'=>$this->getUser()
        ]);

        return $this->render('user/index.html.twig', [
            'favorites'=>$favorites,
            'reservations'=>$reservations,
            'reservationsHotels'=>$reservationsHotels
        ]);
    }


    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {

        if($request->getMethod()==='POST')
        {
            $user= new User();
            $user->setNume($request->get('_nume'));
            $user->setPrenume($request->get('_prenume'));
            $user->setEmail($request->get('_email'));
            $user->setParola($request->get('_parola'));
            $user->setEnabled(false);
            $token= bin2hex(openssl_random_pseudo_bytes(50));
            $user->setToken($token);
            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new Email())
                ->from('ionela.licenta@gmail.com')
                ->to($user->getEmail())
                ->subject('Acesta este un email de confirmare adresa de e-mail la aplicatia Praga')
                ->html('<p>Tot ce trebuie sa faci este sa dai click pe linkul urmator!<a href="http://symfony.localhost/register/confirm?token='.$token.'">Aici !</a></p>');

            $mailer->send($email);


            return $this->render('login/register.html.twig', array(
                'message'=>'Utilizator inregistrat. Verifica adresa de e-mail pentru confirmare.'
            ));
        }

        return $this->render('login/register.html.twig', array(


        ));


    }

    /**
     * @Route("/register/confirm", name="app_register_confirm")
     */
    public function registerConfirmation(DoctrineRepositoryGetter $doctrineRepositoryGetter, Request $request, EntityManagerInterface $entityManager)
    {
        $userRepository=$doctrineRepositoryGetter->getRepository(User::class);
        if($request->get('token'))
        {
            $user=$userRepository->findBy([
                'token'=>$request->get('token')
            ]);

            if($user && isset($user[0]))
            {
                $user=$user[0];
                $user->setEnabled(true);
                $user->setToken("");
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        return $this->render('login/registerConfirmation.html.twig', array(
            'message'=>'Daca utilizatorul a existat in baza de date, acesta a fost activat, te vei putea loga cu userul si parola alese.'
        ));
    }

}
