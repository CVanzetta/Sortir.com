<?php

namespace App\Controller;

use App\Form\EditProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/monProfil', name:'profil_monProfil')]
    public function connexionOK(): Response
    {
        return $this->render(view: 'profil/monProfil.html.twig');
    }

    #[Route('/monProfil/modifier', name:'profil_modifierProfil')]
    public function editProfil(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profil_monProfil');
        }
        return $this->render('profil/editProfil.html.twig', [
        'EditProfil' => $form->createView(),
    ]);
    }
}