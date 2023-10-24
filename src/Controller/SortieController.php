<?php

namespace App\Controller;

use App\DTO\SearchData;
use App\Form\SortieFilterType;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Entity\Campus;




class SortieController extends AbstractController
{
    private $entityManager;
    private $authorizationChecker;

    public function __construct(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route("/afficher-sortie/{id}", name: "afficher_sortie")]
    public function afficherSortie($id): Response
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

    public function createSortie(Request $request,EntityManagerInterface $entityManager): Response
    {
        $participant = $this->getUser();

        // Créez une nouvelle instance de Sortie
        $sortie = new Sortie();

        // Attribuez l'utilisateur actuel comme organisateur de la sortie
        $sortie->setOrganisateur($participant);

        // Créez et gérez le formulaire, persistez la sortie, etc.
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $this->entityManager->persist($sortie);
            $this->entityManager->flush();

            // Redirigez l'utilisateur vers la page d'affichage de la sortie ou une autre page appropriée.
            return $this->redirectToRoute('afficher_sortie', ['id' => $sortie->getId()]);
        }

        return $this->render('sortie/create.html.twig', [
            'sortieForm' => $sortieForm->createView(),
        ]);
    }
    #[Route('/inscription/{id}', name:'inscription_sortie')]

    public function inscrireSortie(Request $request, EntityManagerInterface $entityManager, Sortie $sortie, UserInterface $participant): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifiez si le participant est déjà inscrit à cette sortie
        if (!$sortie->getParticipants()->contains($participant)) {
            // Vérifiez si la date limite d'inscription est dépassée
            $dateLimiteInscription = $sortie->getDateLimiteInscription();
            $now = new \DateTime();
            if ($dateLimiteInscription >= $now) {

                // Le participant peut s'inscrire
                $sortie->addParticipant($participant);
                $entityManager->persist($sortie);
                $entityManager->flush();

                $this->addFlash('success', 'Vous avez bien été inscrit à cette sortie.');

            } else {
                // La date limite d'inscription est dépassée, renvoyez un message d'erreur
                $this->addFlash('error', 'La date limite d\'inscription est dépassée.');
            }
        } else {
            // Le participant est déjà inscrit, renvoyez un message d'erreur
            $this->addFlash('error', 'Vous êtes déjà inscrit à cette sortie.');
        }

        return $this->redirectToRoute('afficher_sortie', ['id' => $sortie->getId()]);
    }

    #[Route('/liste-sorties', name: 'liste_sorties')]
    public function listeSorties(Request $request, Security $security, SortieRepository $sortieRepository): Response
    {
        //var_dump($request->query->all());

        // Récupérez les données du formulaire
        $form = $this->createForm(SortieFilterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $searchData = new SearchData(); // Créez une instance de SearchData

            if ($data['campus']) {
                $searchData->setCampus($data['campus']->getId()); // Utilisez l'ID du campus
            }

            if ($data['dateDebut']) {
                $searchData->setDateDebut($data['dateDebut']);
            }

            if ($data['dateFin']) {
                $searchData->setDateFin($data['dateFin']);
            }

            if ($data['keyword']) {
                $searchData->setKeyword($data['keyword']);
            }

            if ($data['organisateur']) {
                $searchData->setOrganisateur($security->getUser());
            }

            if ($data['inscrit']) {
                $searchData->setInscrit($security->getUser());
            }

            if ($data['nonInscrit']) {
                $searchData->setNonInscrit(true);
            }

            if ($data['passees']) {
                $searchData->setPassees(true);
            }

            // Récupérez les sorties en utilisant le repository
            $sorties = $sortieRepository->findSearch($searchData);

            if (empty($sorties)) {
                $this->addFlash('info', 'Aucun résultat trouvé.');
            }
        } else {
            $sorties = $sortieRepository->findAll();
        }

        return $this->render('sortie/liste_sorties.html.twig', [
            'form' => $form->createView(),
            'sorties' => $sorties,
        ]);
    }

}