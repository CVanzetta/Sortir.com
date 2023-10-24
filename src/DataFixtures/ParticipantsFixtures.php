<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Annotation\Groups;


#[Groups(['kurai_d'])]
class ParticipantsFixtures extends Fixture implements FixtureGroupInterface,DependentFixtureInterface
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        // Créez des données de Participants
        $participant1 = new Participant();
        $participant1->setNom('Bonriner');
        $participant1->setPrenom('Martin');
        $participant1->setTelephone('0425869378');
        $participant1->setEmail('bonriner@me.com');

        $hashPassword = $this->hasher->hashPassword(
            $participant1, 'yoyoyo');
        $participant1->setMotPasse($hashPassword);

        $participant1->setAdministrateur(false);

        $campus = $this->getReference('campus_angers');
        $participant1->setCampus($campus);
        $participant1->setActif(true);

        $participant2 = new Participant();
        $participant2->setNom('Couplétêt');
        $participant2->setPrenom('Tiripou');
        $participant2->setTelephone('0404040404');
        $participant2->setEmail('Karaba@example.com');

        $hashPassword = $this->hasher->hashPassword(
            $participant2, 'yéyéyé');
        $participant2->setMotPasse($hashPassword);

        $participant2->setAdministrateur(false);
        $campus = $this->getReference('campus_rennes');
        $participant2->setCampus($campus);
        $participant2->setActif(true);


        $participant3 = new Participant();
        $participant3->setNom('Cavendish');
        $participant3->setPrenom('Jacob');
        $participant3->setTelephone('0678541298');
        $participant3->setEmail('cavendish.jacob@me.com');

        $hashPassword = $this->hasher->hashPassword(
            $participant3, 'Pa$$w0rd');
        $participant3->setMotPasse($hashPassword);

        $participant3->setAdministrateur(true);
        $campus = $this->getReference('campus_ligne');
        $participant3->setCampus($campus);
        $participant3->setActif(true);


        $participant4 = new Participant();
        $participant4->setNom('Doe');
        $participant4->setPrenom('John');
        $participant4->setTelephone('1234567890');
        $participant4->setEmail('johndoe@example.com');

        $hashPassword = $this->hasher->hashPassword(
            $participant4, 'password123');
        $participant4->setMotPasse($hashPassword);

        $participant4->setAdministrateur(false);

        $campus = $this->getReference('campus_nantes');
        $participant4->setCampus($campus);
        $participant4->setActif(true);

        $participant5 = new Participant();
        $participant5->setNom('Parker');
        $participant5->setPrenom('Peter');
        $participant5->setTelephone('9876543210');
        $participant5->setEmail('spidey@example.com');

        $hashPassword = $this->hasher->hashPassword(
            $participant5, 'webcrawler');
        $participant5->setMotPasse($hashPassword);

        $participant5->setAdministrateur(false);

        $campus = $this->getReference('campus_angers');
        $participant5->setCampus($campus);
        $participant5->setActif(true);



        // Enregistrez les données dans la base de données
        $manager->persist($participant1);
        $manager->persist($participant2);
        $manager->persist($participant3);
        $manager->persist($participant4);
        $manager->persist($participant5);

        // Exécutez la requête pour insérer les données dans la base de données
        $manager->flush();
    }
    public static function getGroups(): array
    {
        return ['kurai_d'];
    }

    public function getDependencies(): array
    {
        return [
            CampusFixtures::class,
            LieuFixtures::class,
        ];
    }
}

