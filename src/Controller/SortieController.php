<?php

namespace App\Controller;

use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class SortieController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/afficher-sortie/{id}", name="afficher_sortie")
     */
    public function afficherSortie($id)
    {
        $sortie = $this->entityManager->getRepository(Sortie::class)->find($id);

        if (!$sortie) {
            throw $this->createNotFoundException('La sortie avec l\'ID ' . $id . ' n\'existe pas.');
        }

        return $this->render('sortie/afficher.html.twig', [
            'sortie' => $sortie,
        ]);

    }

    #[Route('/createSortie', name:'create_sortie')]
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    public function createSortie(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        // Récupérez l'utilisateur actuellement connecté
        /** @var UserInterface $participant */
        $participant = $security->getUser();

        // Créez une nouvelle instance de Sortie
        $sortie = new Sortie();

        // Attribuez l'utilisateur actuel comme organisateur de la sortie
        $sortie->setOrganisateur($participant);

        // Créez et gérez le formulaire, persistez la sortie, etc.

        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

            $entityManager->persist($sortie);
            $entityManager->flush();
        }
        return $this->render('sortie/create.html.twig', [
            'sortieForm' => $sortieForm->createView(),
        ]);
    }

}
