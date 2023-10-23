<?php

namespace App\Controller;

use App\Form\SortieFilterType;
use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    public function createSortie(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        // Vérifiez si l'utilisateur est autorisé à créer une sortie (ajoutez des contrôles d'accès si nécessaire).
        if (!$this->authorizationChecker->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        // Créez une nouvelle instance de Sortie
        $sortie = new Sortie();

        // Attribuez l'utilisateur actuel comme organisateur de la sortie
        $sortie->setOrganisateur($user);

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

    // Controller
    #[Route('/liste-sorties', name: 'liste_sorties')]
    public function listeSorties(Request $request, Security $security): Response
    {
        $repository = $this->entityManager->getRepository(Sortie::class);

        // Créez et gérez le formulaire
        $form = $this->createForm(SortieFilterType::class, null, [
            'campus_choices' => $this->getCampusList(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $criteria = [];

            if ($data['campus']) {
                $criteria['campus'] = $data['campus'];
            }

            if ($data['dateDebut']) {
                $criteria['dateHeureDebut'] = $data['dateDebut'];
            }

            if ($data['dateFin']) {
                $criteria['dateHeureFin'] = $data['dateFin'];
            }

            if ($data['keyword']) {
                $criteria['nom'] = $data['keyword'];
            }

            if ($data['organisateur']) {
                $criteria['organisateur'] = $security->getUser();
            }

            if ($data['inscrit']) {
                $criteria['participants'] = $security->getUser();
            }

            if ($data['nonInscrit']) {
                $criteria['participants'] = null;
            }

            if ($data['passees']) {
                $criteria['dateHeureDebut'] = new \DateTime('now');
            }

            $sorties = $repository->findBy($criteria);

            if (empty($sorties)) {
                $this->addFlash('info', 'Aucun résultat trouvé.');
            }
        } else {
            $sorties = $repository->findAll();
        }

        return $this->render('sortie/liste_sorties.html.twig', [
            'form' => $form->createView(),
            'sorties' => $sorties,
        ]);
    }

    private function getCampusList()
    {
        $campusRepository = $this->entityManager->getRepository(Campus::class);
        $campusList = $campusRepository->findAll();

        $choices = [];

        foreach ($campusList as $campus) {
            $choices[$campus->getNom()] = $campus->getId();
        }

        return $choices;
    }
}