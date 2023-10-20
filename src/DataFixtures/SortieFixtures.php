<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $sortie = new Sortie();
        $sortie->setNom('Sortie de test');
        $sortie->setDateHeureDebut(new \DateTime('2023-10-18 15:00:00'));
        $sortie->setDuree(3);
        $sortie->setDateLimiteInscription(new \DateTime('2023-10-17'));
        $sortie->setNbInscriptionsMax(10);
        $sortie->setInfosSortie('Ceci est une sortie de test.');

        // Exemple : Relation avec Campus
        $campus = $manager->getRepository(Campus::class)->findOneBy(['nom' => 'Angers']);
        $sortie->setCampus($campus);

        // Exemple : Relation avec Lieu
        $lieu = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Palais Garnier']);
        $sortie->setLieu($lieu);

        // Exemple : Relation avec Etat
        $etat = $manager->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
        $sortie->setEtat($etat);

        // Exemple : Relation avec Organisateur
        $organisateur = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Couplétêt']);
        $sortie->setOrganisateur($organisateur);

        // Exemple : ajouter des participants à la sortie
        $participant1 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Bonriner']);
        $participant2 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Cavendish']);
        $sortie->addParticipant($participant1);
        $sortie->addParticipant($participant2);

        $manager->persist($sortie);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            VilleFixtures::class,
            LieuFixtures::class,
            ParticipantsFixtures::class,
        ];
    }
}
