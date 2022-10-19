<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactPageController extends AbstractController
{
    #[Route(
        path: '/contact',
        name: 'app_contact_page',
    )]
    public function index()
    {
        return $this->render('contact/contact.html.twig');
    }
}
