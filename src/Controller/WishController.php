<?php

namespace App\Controller;


use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        //$wishes = $wishRepository->findAllIdeas();
        $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'DESC']);

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

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Crée une nouvelle instance de l'entité "Wish".
        $wish = new Wish();

        // Crée une instance de la classe DateTime avec la date actuelle
        $dateCreated = new \DateTime();
        // Définis le fuseau horaire sur "Europe/Paris" (pour l'heure française)
        $dateCreated->setTimezone(new \DateTimeZone('Europe/Paris'));
        // Formate la date au format français
        $dateCreatedFormatted = $dateCreated->format('d/m/Y H:i');
        $wish->setDateCreated(new \DateTime()); // Ce champ n'est pas dans le formulaire.

        $wish->setIsPublished(true); // Ce champ n'est pas dans le formulaire.

        // Crée un formulaire basé sur le type "WhishType" et associe l'instance du wish.
        $wishForm = $this->createForm(WishType::class, $wish);
        // À ce stade, le formulaire a été créé, mais il reste à le traiter.

        //logique de traitement du formulaire :
        $wishForm->handleRequest($request); // $wish contient les données du formulaire.

        // isValid est important pour la sécurité il empêche les attaques CSRF.
        if ($wishForm->isSubmitted() && $wishForm->isValid()){
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('succes', 'Souhait ajouté !');

            // Redirection vers la page détails de la nouvelle entrée.
            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }

        // Une fois le formulaire traité, généralement, on enregistre les données en base de données.
        // Cependant, dans le code actuel, cela n'est pas encore implémenté.

        // Enfin, on rend une vue Twig pour afficher le formulaire.
        return $this->render('main/add.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);
    }
}