<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etat;

class EtatFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $etatsData =    [
            ['libelle' => 'En création'],
            ['libelle' => 'Ouverte'],
            ['libelle' => 'Clôturée'],
            ['libelle' => 'Activité en cours'],
            ['libelle' => 'Passée'],
            ['libelle' => 'Annulée'],
        ];


        foreach ($etatsData as $etatData) {
            $etat = new Etat();
            $etat->setLibelle($etatData['libelle']);
            $manager->persist($etat);

            $this->addReference('etat_' . $etatData['libelle'], $etat);
        }

        $manager->flush();
    }
}
