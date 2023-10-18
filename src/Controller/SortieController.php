<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;

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
}
