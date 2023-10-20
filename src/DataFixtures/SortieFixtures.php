<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sorty = new Sortie();
        $sorty->setNom('Sortie de test');
        $sorty->setDateHeureDebut(new \DateTime('2023-10-18 15:00:00'));
        $sorty->setDuree(3);
        $sorty->setDateLimiteInscription(new \DateTime('2023-10-17'));
        $sorty->setNbInscriptionsMax(10);
        $sorty->setInfosSortie('Ceci est une sortie de test.');

        // Exemple : Relation avec Campus
        $campus = $manager->getRepository(Campus::class)->findOneBy(['nom' => 'Angers']);
        $sorty->setCampus($campus);

       // Exemple : Relation avec Lieu
        $lieu = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Palais Garnier']);
        $sorty->setLieu($lieu);

        // Exemple : Relation avec Etat
        $etat = $manager->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
        $sorty->setEtat($etat);

        // Exemple : Relation avec Organisateur
        $organisateur = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'NomDeLOrganisateur']);
        $sorty->setOrganisateur($organisateur);

        // Exemple : ajouter des participants à la sortie
        $participant1 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Bonriner']);
        $participant2 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Cavendish']);
        $sorty->addParticipant($participant1);
        $sorty->addParticipant($participant2);

        $manager->persist($sorty);
        $manager->flush();
    }

}
