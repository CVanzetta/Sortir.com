<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $villes = [
            'Paris',
            'Lyon',
            'Marseille',
            'Nantes',
            'Poitiers',
        ];

        foreach ($villes as $nom) {
            $ville = new Ville();
            $ville->setNom($nom);

            $manager->persist($ville);
        }

        $manager->flush();
    }
}