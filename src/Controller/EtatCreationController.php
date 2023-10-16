<?php

namespace App\Controller;

use App\Entity\Etat;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtatCreationController extends AbstractController
{
    #[Route('/etat/creation', name: 'app_etat_creation')]
    public function index(): Response
    {
        return $this->render('etat_creation/index.html.twig', [
            'controller_name' => 'EtatCreationController',
        ]);
    }
                            //c'est un test pour crée les différents etats
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/etat/create', name: 'app_create_etats')]
    public function createEtats (EntityManager $entityManager): Response
    {

    // ajouter des états
        $etat1 = new Etat();
        $etat1->setNom("Créée");

        $etat2 = new Etat();
        $etat2->setNom("Ouverte");

        $etat3 = new Etat();
        $etat3->setNom("Clôturée");

        $etat4 = new Etat();
        $etat4->setNom("Activité en Cours");

        $etat5 = new Etat();
        $etat5->setNom("Passée");

        $etat6 = new Etat();
        $etat6->setNom("Annulée");

        // Enregistrez dans la base de données
        $entityManager->persist($etat1);
        $entityManager->persist($etat2);
        $entityManager->persist($etat3);
        $entityManager->persist($etat4);
        $entityManager->persist($etat5);
        $entityManager->persist($etat6);
        $entityManager->flush();
        return new Response('États créés avec succès !');
    }


}
