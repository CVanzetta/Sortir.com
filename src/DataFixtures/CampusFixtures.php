<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $campus1 = new Campus();
        $campus1->setNom('Angers');
        $this->addReference('campus_angers', $campus1);
        $manager->persist($campus1);

        $campus2 = new Campus();
        $campus2->setNom('Rennes');
        $this->addReference('campus_rennes', $campus2);
        $manager->persist($campus2);

        $campus3 = new Campus();
        $campus3->setNom('Nantes');
        $this->addReference('campus_nantes', $campus3);
        $manager->persist($campus3);

        $campus4 = new Campus();
        $campus4->setNom('En Ligne');
        $this->addReference('campus_ligne', $campus4);
        $manager->persist($campus4);

        $manager->flush();
    }
}
