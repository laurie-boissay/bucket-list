<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="main_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    function home(){
        return $this-> render('main/home.html.twig');
    }

    /**
     * @Route("/aboutUs", name="aboutUs")
     */
    function aboutUs(){
        return $this-> render('main/aboutUs.html.twig');
    }
}