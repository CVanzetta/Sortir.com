<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Annotation\Groups;

#[Groups(['kurai_d'])]
class CampusFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        // Créez des données de campus
        $campusRennes = new Campus();
        $campusRennes->setNom('Campus Rennes');

        $campusAngers = new Campus();
        $campusAngers->setNom('Campus Angers');

        $campusEnLigne = new Campus();
        $campusEnLigne->setNom('Campus en Ligne');

        // Enregistrez les données dans la base de données
        $manager->persist($campusRennes);
        $this->addReference('campusRennes', $campusRennes);

        $manager->persist($campusAngers);
        $this->addReference('campusAngers', $campusAngers);

        $manager->persist($campusEnLigne);
        $this->addReference('campusEnLigne', $campusEnLigne);

        // Exécutez la requête pour insérer les données dans la base de données
        $manager->flush();
    }
    public static function getGroups(): array
    {
        return ['kurai_d'];
    }
}