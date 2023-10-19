<?php

namespace App\Controller;

use App\Entity\Campus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    #[Route('/addcampus', name:'main_campus')]
    public function addCampus(EntityManagerInterface $entityManager): Response
    {
        $campus = new Campus();
        $campus->setNom('Angers');

        $entityManager->persist($campus);

        $campus = new Campus();
        $campus->setNom('Rennes');

        $entityManager->persist($campus);

        $campus = new Campus();
        $campus->setNom('Nantes');

        $entityManager->persist($campus);

        $entityManager->flush();


        return $this->render(view: 'main/campus.html.twig');
    }
}