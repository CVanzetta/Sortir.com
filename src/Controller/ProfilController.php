<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\EditProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfilController extends AbstractController
{
    #[Route('/monProfil', name:'profil_monProfil')]
    public function editProfil(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, PasswordAuthenticatedUserInterface $user): Response
    {
        /** @var Participant $participant */
        $participant = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $participant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPass = $form->get('newPass')->getData();
            if (null != $newPass) {
                $participant->setMotPasse($passwordHasher->hashPassword($user, $newPass));

                /*$hashPass = $passwordHasher->hashPassword(
                    $user,
                    $newPass);
                $participant->setMotPasse($hashPass);*/
            }
            $entityManager->persist($participant);
            $entityManager->flush();


            return $this->redirectToRoute('main_home');
        }
        return $this->render('profil/editProfil.html.twig', [
        'EditProfil' => $form->createView(),
    ]);
    }
}