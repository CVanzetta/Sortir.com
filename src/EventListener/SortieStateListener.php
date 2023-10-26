<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\Sortie;

class SortieStateListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'sortie.refresh_state' => 'onSortieRefreshState',
        ];
    }

    public function onSortieRefreshState(GenericEvent $event): void
    {
        // Récupérez la sortie depuis l'événement
        $sortie = $event->getSubject();

        // Recalcul de l'état en fonction du nombre de participants, de la date, etc.
        $etat = $this->determineSortieState($sortie);

        // Mettez à jour l'état de la sortie
        $sortie->setEtat($etat);
    }

    private function determineSortieState(Sortie $sortie)
    {
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
                break; // Sortie du boucle dès qu'une condition est remplie
            }


        }  return $etat;
    }
}
