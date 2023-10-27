<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\EditProfilType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Service\AvatarService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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
    public function editProfil(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher,
    AvatarService $avatarService, ParameterBagInterface $params): Response
    {
        /** @var Participant $participant */
        $participant = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $participant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPass = $form->get('newPass')->getData();
            if (null != $newPass) {
                $participant->setMotPasse($passwordHasher->hashPassword($participant, $newPass));

                /*$hashPass = $passwordHasher->hashPassword(
                    $user,
                    $newPass);
                $participant->setMotPasse($hashPass);*/
            }
            $avatar = $form->get('avatar')->getData();
            if (null != $avatar) {
                $avatarName = $participant->getAvatar();
                $avatarService->delete($avatarName);
            }
            $fichier = $avatarService->add($avatar);
            $participant->setAvatar($fichier);
            $entityManager->persist($participant);
            $entityManager->flush();


            return $this->redirectToRoute('main_home');
        }
        return $this->render('profil/editProfil.html.twig', [
        'EditProfil' => $form->createView(),
        'participant' => $participant
    ]);
    }

    #[Route('/profil/{id}', name:'profil_afficherProfil')]
    public function afficherProfil(Campus $campus, int $id, ParticipantRepository $participantRepository): Response
    {
        /** @var Participant $participant */
        $participant = $participantRepository->find($id);

        return $this->render('profil/afficherProfil.html.twig', [
            "participant" => $participant,
            "campus" => $campus
        ]);
    }
}