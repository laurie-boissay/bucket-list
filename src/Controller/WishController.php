<?php

namespace App\Controller;


use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wishes", name="whish_")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    function list(){
        //afficher a liste des choses à faire une fois dans sa vie.
        return $this-> render('main/list.html.twig');
    }

    /**
     * @Route("/detail{id}", name="detail", requirements={"id"="\d+"})
     */
    function detail(int $id):Request
    {
        return $this-> render('main/detail.html.twig');
    }
}