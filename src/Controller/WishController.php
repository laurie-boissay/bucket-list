<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\String_;
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
    public function list(WishRepository $wishRepository): Response
    {
        // récupère les Wish publiés, du plus récent au plus ancien
        // $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'DESC']);
        // on appelle une méthode personnalisée ici pour éviter d'avoir trop de requêtes.
        $wishes = $wishRepository->findPublishedWishesWithCategories();
        return $this->render('main/list.html.twig', [
            // les passe à Twig
            "wishes" => $wishes
        ]);
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
        $wish->setIsPublished(true); // Ce champ ne dois pas être modifié par l'utilisateur.

        // Préremplir le champ pseudo
        $currentUserUsername = $this->getUser()->getUserIdentifier();
        $wish->setAuthor($currentUserUsername);

        // Crée un formulaire basé sur le type "WhishType" et associe l'instance du wish.
        $wishForm = $this->createForm(WishType::class, $wish);
        // À ce stade, le formulaire a été créé, mais il reste à le traiter.

        //logique de traitement du formulaire :
        $wishForm->handleRequest($request); // $wish contient les données du formulaire.

        // isValid est important pour la sécurité il empêche les attaques CSRF.
        if ($wishForm->isSubmitted() && $wishForm->isValid()){
            $wish->setDateCreated(new \DateTime()); // Ce champ ne dois pas être modifié par l'utilisateur.
            // Sauvegarde en BdD
            $entityManager->persist($wish);
            // Confirmation
            $entityManager->flush();

            $this->addFlash('success', 'Idée ajoutée !');

            // Redirection vers la page détails de la nouvelle entrée.
            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }

        // Enfin, on rend une vue Twig pour afficher le formulaire.
        return $this->render('main/add.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);
    }
}