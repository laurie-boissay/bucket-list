<?php

namespace App\Controller;


use App\Repository\WishRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wishes", name="wish_")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    function list(WishRepository $wishRepository): Response
    {
        // Récupère la liste des choses à faire à partir du wishRepository.
        $wishes = $wishRepository->findAllIdeas();
        dump($wishes);

        return $this-> render('main/list.html.twig', [
        "wishes" => $wishes]);
    }

    /**
     * @Route("/detail{id}", name="detail", requirements={"id"="\d+"})
     */
    public function detail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        return $this->render(
            'main/detail.html.twig',
            ["wish" => $wish]
        );
    }
}