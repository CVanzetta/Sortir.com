<?php

namespace App\Controller;

use App\Entity\Etat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class EtatsController extends AbstractController
{
    #[Route('/addetats', name:'main_etats')]
    public function addEtats(EntityManagerInterface $entityManager): Response
    {
        $etatRepository = $entityManager->getRepository(Etat::class);
        $existingEtats = $etatRepository->findAll();

        if (empty($existingEtats)) {
            // ajouter des états
            $etat1 = new Etat();
            $etat1->setLibelle("Créée");

            $etat2 = new Etat();
            $etat2->setLibelle("Ouverte");

            $etat3 = new Etat();
            $etat3->setLibelle("Clôturée");

            $etat4 = new Etat();
            $etat4->setLibelle("Activité en Cours");

            $etat5 = new Etat();
            $etat5->setLibelle("Passée");

            $etat6 = new Etat();
            $etat6->setLibelle("Annulée");

            $etat7 = new Etat();
            $etat7->setLibelle("Archivée");

            $etat8 = new Etat();
            $etat8->setLibelle("Publiée");


            // Enregistrez dans la base de données
            $entityManager->persist($etat1);
            $entityManager->persist($etat2);
            $entityManager->persist($etat3);
            $entityManager->persist($etat4);
            $entityManager->persist($etat5);
            $entityManager->persist($etat6);
            $entityManager->persist($etat7);
            $entityManager->persist($etat8);
            $entityManager->flush();
        }
        return $this->redirectToRoute('main_home');
    }

}