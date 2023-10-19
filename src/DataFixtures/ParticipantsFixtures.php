<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Annotation\Groups;


#[Groups(['kurai_d'])]
class ParticipantsFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {

        // Créez des données de Participants
        $participant1 = new Participant();
        $participant1->setNom('Bonriner');
        $participant1->setPrenom('Martin');
        $participant1->setTelephone('0425869378');
        $participant1->setMail('bonriner@me.com');
        $participant1->setMotPasse('yoyoyo');
        $participant1->setAdministrateur(false);
        $participant1->setCampus($this->getReference('campusRennes'));
        $participant1->setActif(true);

        $participant2 = new Participant();
        $participant2->setNom('Couplétêt');
        $participant2->setPrenom('Tiripou');
        $participant2->setTelephone('0404040404');
        $participant2->setMail('Karaba@example.com');
        $participant2->setMotPasse('yéyéyé');
        $participant2->setAdministrateur(false);
        $participant2->setCampus($this->getReference('campusAngers'));
        $participant2->setActif(true);


        $participant3 = new Participant();
        $participant3->setNom('Cavendish');
        $participant3->setPrenom('Jacob');
        $participant3->setTelephone('0678541298');
        $participant3->setMail('cavendish.jacob@me.com');
        $participant3->setMotPasse('Pa$$w0rd');
        $participant3->setAdministrateur(true);
        $participant3->setCampus($this->getReference('campusEnLigne'));
        $participant3->setActif(true);


        // Enregistrez les données dans la base de données
        $manager->persist($participant1);
        $manager->persist($participant2);
        $manager->persist($participant3);

        // Exécutez la requête pour insérer les données dans la base de données
        $manager->flush();
    }
    public static function getGroups(): array
    {
        return ['kurai_d'];
    }
}

