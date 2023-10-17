<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="registration")
     */
    public function registration(Request $request): Response
    {
        $participant = new Participant(); // Créez une instance de votre entité Participant
        $form = $this->createForm(InscriptionType::class, $participant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez la soumission du formulaire, par exemple, en enregistrant l'utilisateur en base de données

            // Redirigez l'utilisateur vers une autre page, par exemple, la page de connexion
        }

        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}