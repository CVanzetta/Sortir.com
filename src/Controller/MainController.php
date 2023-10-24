<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name:'main_home')]
    public function home(EtatsController $etatsController, CampusController $campusController): Response
    {
        $etatsController->addEtats($this->entityManager);
        $campusController->addCampus($this->entityManager);

        if ($this->isGranted('IS_AUTHENTICATED')){
            return $this->render(view: 'main/home.html.twig');
        } else {
        return $this->render(view: 'security/login.html.twig');
        }
    }
    #[Route('/connexionOK', name:'main_connexionOK')]
    public function connexionOK(): Response
    {
        return $this->render(view: 'main/home.html.twig');
    }
}