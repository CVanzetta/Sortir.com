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

        // Sortie 1
        $sortie1 = new Sortie();
        $sortie1->setNom('Sortie à Palais Garnier');
        $sortie1->setDateHeureDebut(new \DateTime('2023-10-20 13:00:00'));
        $sortie1->setDuree(5);
        $sortie1->setDateLimiteInscription(new \DateTime('2023-10-19'));
        $sortie1->setNbInscriptionsMax(20);
        $sortie1->setInfosSortie('Sortie culturelle au Palais Garnier.');

        $campus1 = $manager->getRepository(Campus::class)->findOneBy(['nom' => 'Angers']);
        $sortie1->setCampus($campus1);

        $lieu1 = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Palais Garnier']);
        $sortie1->setLieu($lieu1);

        $etat1 = $manager->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
        $sortie1->setEtat($etat1);

        $organisateur1 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Bonriner']);
        $sortie1->setOrganisateur($organisateur1);

        $participant2 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Cavendish']);
        $participant3 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Parker']);
        $sortie1->addParticipant($participant2);
        $sortie1->addParticipant($participant3);

        $manager->persist($sortie1);

        // Sortie 2
        $sortie2 = new Sortie();
        $sortie2->setNom('Sortie au Futuroscope');
        $sortie2->setDateHeureDebut(new \DateTime('2023-10-21 10:00:00'));
        $sortie2->setDuree(6);
        $sortie2->setDateLimiteInscription(new \DateTime('2023-10-20'));
        $sortie2->setNbInscriptionsMax(25);
        $sortie2->setInfosSortie('Journée au Futuroscope à Poitiers.');

        $campus2 = $manager->getRepository(Campus::class)->findOneBy(['nom' => 'Rennes']);
        $sortie2->setCampus($campus2);

        $lieu2 = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Futuroscope']);
        $sortie2->setLieu($lieu2);

        $etat2 = $manager->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
        $sortie2->setEtat($etat2);

        $organisateur2 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Doe']);
        $sortie2->setOrganisateur($organisateur2);

        $participant4 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Cavendish']);
        $participant5 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Doe']);
        $participant6 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Couplétêt']);
        $sortie2->addParticipant($participant4);
        $sortie2->addParticipant($participant5);
        $sortie2->addParticipant($participant6);

        $manager->persist($sortie2);

        // Sortie 3
        $sortie3 = new Sortie();
        $sortie3->setNom('Randonnée au Mont-Saint-Michel');
        $sortie3->setDateHeureDebut(new \DateTime('2023-11-05 09:30:00'));
        $sortie3->setDuree(4);
        $sortie3->setDateLimiteInscription(new \DateTime('2023-11-04'));
        $sortie3->setNbInscriptionsMax(15);
        $sortie3->setInfosSortie('Sortie de randonnée autour du Mont-Saint-Michel.');

        $campus3 = $manager->getRepository(Campus::class)->findOneBy(['nom' => 'En Ligne']);
        $sortie3->setCampus($campus3);

        $lieu3 = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Mont-Saint-Michel']);
        $sortie3->setLieu($lieu3);

        $etat3 = $manager->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
        $sortie3->setEtat($etat3);

        $organisateur3 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Doe']);
        $sortie3->setOrganisateur($organisateur3);

        $participant7 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Bonriner']);

        $sortie3->addParticipant($participant7);

        $manager->persist($sortie3);

// Sortie 4
        $sortie4 = new Sortie();
        $sortie4->setNom('Sortie culturelle et Fun');
        $sortie4->setDateHeureDebut(new \DateTime('2023-11-15 14:00:00'));
        $sortie4->setDuree(3);
        $sortie4->setDateLimiteInscription(new \DateTime('2023-11-14'));
        $sortie4->setNbInscriptionsMax(12);
        $sortie4->setInfosSortie('Visite du Puy du Fou.');

        $campus4 = $manager->getRepository(Campus::class)->findOneBy(['nom' => 'Angers']);
        $sortie4->setCampus($campus4);

        $lieu4 = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Puy du Fou']);
        $sortie4->setLieu($lieu4);

        $etat4 = $manager->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
        $sortie4->setEtat($etat4);

        $organisateur4 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Parker']);
        $sortie4->setOrganisateur($organisateur4);

        $participant8 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Parker']);
        $participant9 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Bonriner']);
        $sortie4->addParticipant($participant8);
        $sortie4->addParticipant($participant9);

        $manager->persist($sortie4);

// Sortie 5
        $sortie5 = new Sortie();
        $sortie5->setNom('Soirée Chambord');
        $sortie5->setDateHeureDebut(new \DateTime('2023-12-01 20:00:00'));
        $sortie5->setDuree(4);
        $sortie5->setDateLimiteInscription(new \DateTime('2023-11-30'));
        $sortie5->setNbInscriptionsMax(30);
        $sortie5->setInfosSortie('Soirée pour socialiser et discuter.');

        $campus5 = $manager->getRepository(Campus::class)->findOneBy(['nom' => 'En Ligne']);
        $sortie5->setCampus($campus5);

        $lieu5 = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Château de Chambord']);
        $sortie5->setLieu($lieu5);

        $etat5 = $manager->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
        $sortie5->setEtat($etat5);

        $organisateur5 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Couplétêt']);
        $sortie5->setOrganisateur($organisateur5);

        $participant10 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Parker']);
        $participant11 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Cavendish']);
        $sortie5->addParticipant($participant10);
        $sortie5->addParticipant($participant11);

        $manager->persist($sortie5);

// Sortie 6
        $sortie6 = new Sortie();
        $sortie6->setNom('Tour de Poitiers');
        $sortie6->setDateHeureDebut(new \DateTime('2023-11-25 11:30:00'));
        $sortie6->setDuree(5);
        $sortie6->setDateLimiteInscription(new \DateTime('2023-11-24'));
        $sortie6->setNbInscriptionsMax(18);
        $sortie6->setInfosSortie('Tour de la ville de Poitiers.');

        $campus6 = $manager->getRepository(Campus::class)->findOneBy(['nom' => 'Angers']);
        $sortie6->setCampus($campus6);

        $lieu6 = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Futuroscope']);
        $sortie6->setLieu($lieu6);

        $etat6 = $manager->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
        $sortie6->setEtat($etat6);

        $organisateur6 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Parker']);
        $sortie6->setOrganisateur($organisateur6);


        $manager->persist($sortie6);


        // Sortie 7
        $sortie7 = new Sortie();
        $sortie7->setNom('il y a plus de un mois');
        $sortie7->setDateHeureDebut(new \DateTime('2023-06-25 11:30:00'));
        $sortie7->setDuree(5);
        $sortie7->setDateLimiteInscription(new \DateTime('2023-06-24'));
        $sortie7->setNbInscriptionsMax(18);
        $sortie7->setInfosSortie('trop vieux');

        $campus7 = $manager->getRepository(Campus::class)->findOneBy(['nom' => 'Angers']);
        $sortie7->setCampus($campus7);

        $lieu7 = $manager->getRepository(Lieu::class)->findOneBy(['nom' => 'Futuroscope']);
        $sortie7->setLieu($lieu7);

        $etat7 = $manager->getRepository(Etat::class)->findOneBy(['libelle' => 'Passée']);
        $sortie7->setEtat($etat7);

        $organisateur7 = $manager->getRepository(Participant::class)->findOneBy(['nom' => 'Parker']);
        $sortie7->setOrganisateur($organisateur7);


        $manager->persist($sortie7);


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
