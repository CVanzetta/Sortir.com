<?php


namespace App\Service;

use App\Entity\Sortie;

class SortieStateService
{
    public function calculateState(Sortie $sortie)
    {
        // Votre logique de calcul de l'état ici

        $nbParticipants = $sortie->getParticipants()->count();
        $nbInscriptionsMax = $sortie->getNbInscriptionsMax();
        $dateActuelle = new \DateTime();
        $dateLimiteInscription = $sortie->getDateLimiteInscription();
        $dateActivite = $sortie->getDateHeureDebut();
        $dateArchivation = clone $dateActivite;
        $dateArchivation->modify('+1 month');
        $dateArchiveAnnul = $sortie->getDateAnnulee();

        if ($dateArchiveAnnul !== null) {
            $dateArchiveAnnul->modify('+1 month');
        }

        $conditions = [
            [
                'condition' => $nbParticipants < $nbInscriptionsMax && $dateActuelle < $dateLimiteInscription,
                'etat' => 'Ouverte',
            ],
            [
                'condition' => $nbParticipants == $nbInscriptionsMax,
                'etat' => 'Clôturée',
            ],
            [
                'condition' => $dateActuelle == $dateActivite,
                'etat' => 'Activité en Cours',
            ],
            [
                'condition' => $dateActuelle > $dateActivite,
                'etat' => 'Passée',
            ],
            [
                'condition' => $dateActuelle == $dateArchivation || $dateActuelle == $dateArchiveAnnul,
                'etat' => 'Archivée',
            ],
            [
                'condition' => $sortie->getDateAnnulee() !== null && $dateActuelle->format('Y-m-d H:i:s') === $sortie->getDateAnnulee()->format('Y-m-d H:i:s'),
                'etat' => 'Annulée',
            ],
        ];


        $etat = 'Créée'; // État par défaut

        foreach ($conditions as $condition) {
            if ($condition['condition']) {
                $etat = $condition['etat'];
                break;
            }
        }

        return $etat;
    }
}
