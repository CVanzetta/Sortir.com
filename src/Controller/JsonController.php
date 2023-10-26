<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lieu;
use App\Repository\LieuRepository;

class JsonController extends AbstractController
{
    #[Route('/lieux/{id}}', name: 'get_lieux_by_ville', methods: ["GET"])]
    public function getLieuxByVille(Lieu $Id, LieuRepository $lieuRepository): JsonResponse
    {
        // Récupérez l'entité Lieu correspondant à l'ID fourni
        $lieu = $lieuRepository->find($Id);

        // Récupérez l'ID de la ville associée à ce lieu
        $villeId = $lieu->getVille()->getId();

        // Récupérez les lieux associés à cette ville
        $lieux = $lieuRepository->findBy(['ville' => $villeId]);

        // Transformez les lieux en un tableau de données JSON
        $lieuxData = [];
        foreach ($lieux as $lieu) {
            $lieuxData[] = [
                'id' => $lieu->getId(),
                'nom' => $lieu->getNom(),
                // Ajoutez d'autres données du lieu si nécessaire
            ];
        }

        return new JsonResponse($lieuxData);
    }
}

