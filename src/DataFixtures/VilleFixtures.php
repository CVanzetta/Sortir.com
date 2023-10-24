<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ville1 = new Ville();
        $ville1->setNom('Paris');
        $ville1->setCodePostal('75000');
        $manager->persist($ville1);
        $this->addReference('Paris', $ville1);

        $ville2 = new Ville();
        $ville2->setNom('Lyon');
        $ville2->setCodePostal('69000');
        $manager->persist($ville2);
        $this->addReference('Lyon', $ville2);

        $ville3 = new Ville();
        $ville3->setNom('Marseille');
        $ville3->setCodePostal('13000');
        $manager->persist($ville3);
        $this->addReference('Marseille', $ville3);

        $ville4 = new Ville();
        $ville4->setNom('Niort');
        $ville4->setCodePostal('79000');
        $manager->persist($ville4);
        $this->addReference('Niort', $ville4);

        $ville5 = new Ville();
        $ville5->setNom('Poitiers');
        $ville5->setCodePostal('86000');
        $manager->persist($ville5);
        $this->addReference('Poitiers', $ville5);

        $ville6 = new Ville();
        $ville6->setNom('Nantes');
        $ville6->setCodePostal('44000');
        $manager->persist($ville6);
        $this->addReference('Nantes', $ville6);

        $ville7 = new Ville();
        $ville7->setNom('Le Mont-Saint-Michel');
        $ville7->setCodePostal('50170');
        $manager->persist($ville7);
        $this->addReference('Le Mont-Saint-Michel', $ville7);

        $ville8 = new Ville();
        $ville8->setNom('Chambord');
        $ville8->setCodePostal('41250');
        $manager->persist($ville8);
        $this->addReference('Chambord', $ville8);

        $ville9 = new Ville();
        $ville9->setNom('Les Epesses');
        $ville9->setCodePostal('85590');
        $manager->persist($ville9);
        $this->addReference('Les Epesses', $ville9);


        $manager->flush();
    }
}