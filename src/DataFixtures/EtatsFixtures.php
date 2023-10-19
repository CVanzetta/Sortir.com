<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Annotation\Groups;


#[Groups(['kurai_d'])]
class EtatsFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        // ajouter des états
        $etat1 = new Etat();
        $etat1->setLibelle("Créée");

        $etat2 = new Etat();
        $etat2->setLibelle("Ouverte");

        $etat3 = new Etat();
        $etat3->setLibelle("Clôturée");

        $etat4 = new Etat();
        $etat4->setLibelle("Activité en Cours");

        $etat5 = new Etat();
        $etat5->setLibelle("Passée");

        $etat6 = new Etat();
        $etat6->setLibelle("Annulée");

        // Enregistrez dans la base de données
        $manager->persist($etat1);
        $manager->persist($etat2);
        $manager->persist($etat3);
        $manager->persist($etat4);
        $manager->persist($etat5);
        $manager->persist($etat6);
        $manager->flush();
    }
    public static function getGroups(): array
    {
        return ['kurai_d'];
    }
}
