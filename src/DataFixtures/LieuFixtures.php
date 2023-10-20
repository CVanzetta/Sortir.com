<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LieuFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créez une instance de Lieu
        $lieu = new Lieu();
        $lieu->setNom('NomDuLieu');
        $lieu->setRue('Adresse de l\'endroit');
        $lieu->setLatitude(48.8588443); // Latitude réelle
        $lieu->setLongitude(2.2943506); // Longitude réelle

        // Chargez la ville depuis la base de données (remplacez "Paris" par le nom de la ville souhaitée)
        $ville = $manager->getRepository(Ville::class)->findOneBy(['nom' => 'Paris']);

        if ($ville) {
            // Associez la ville au lieu
            $lieu->setVille($ville);
        } else {
            // Gérez le cas où la ville 'Paris' n'existe pas.
        }

        // Persistez le lieu
        $manager->persist($lieu);
        $manager->flush();
    }
}
