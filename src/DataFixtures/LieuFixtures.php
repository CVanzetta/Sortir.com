<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LieuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Lieu 1 : Palais Garnier, Paris
        $lieu1 = new Lieu();
        $lieu1->setNom('Palais Garnier');
        $lieu1->setRue('8 Rue Scribe');
        $lieu1->setLatitude(48.8714105);
        $lieu1->setLongitude(2.3318376);
        $ville1 = $this->getReference('Paris');

        if ($ville1) {
            $lieu1->setVille($ville1);
        }

        $manager->persist($lieu1);

        // Lieu 2 : Futuroscope, Poitiers
        $lieu2 = new Lieu();
        $lieu2->setNom('Futuroscope');
        $lieu2->setRue('Avenue René Monory');
        $lieu2->setLatitude(46.6666013);
        $lieu2->setLongitude(0.3677685);

        $ville5 = $this->getReference('Poitiers');

        if ($ville5) {
            $lieu2->setVille($ville5);
        }

        $manager->persist($lieu2);

        // Lieu 3 : Eiffel Tower, Paris
        $lieu3 = new Lieu();
        $lieu3->setNom('Eiffel Tower');
        $lieu3->setRue('Champ de Mars');
        $lieu3->setLatitude(48.8588443);
        $lieu3->setLongitude(2.2943506);
        $ville1 = $this->getReference('Paris');

        if ($ville1) {
            $lieu3->setVille($ville1);
        }

        $manager->persist($lieu3);

        // Lieu 4 : Louvre Museum, Paris
        $lieu4 = new Lieu();
        $lieu4->setNom('Louvre Museum');
        $lieu4->setRue('Rue de Rivoli');
        $lieu4->setLatitude(48.8606111);
        $lieu4->setLongitude(2.3354557);
        $ville1 = $this->getReference('Paris');

        if ($ville1) {
            $lieu4->setVille($ville1);
        }

        $manager->persist($lieu4);

        // Lieu 5 : Le Mont-Saint-Michel
        $lieu5 = new Lieu();
        $lieu5->setNom('Mont-Saint-Michel');
        $lieu5->setRue('50170 Le Mont-Saint-Michel');
        $lieu5->setLatitude(48.6360865);
        $lieu5->setLongitude(-1.5114596);
        $ville6 = $this->getReference('Le Mont-Saint-Michel');

        if ($ville6) {
            $lieu5->setVille($ville6);
        }

        $manager->persist($lieu5);

        // Lieu 6 : Château de Chambord
        $lieu6 = new Lieu();
        $lieu6->setNom('Château de Chambord');
        $lieu6->setRue('41250 Chambord');
        $lieu6->setLatitude(47.6168385);
        $lieu6->setLongitude(1.5185691);
        $ville7 = $this->getReference('Chambord');

        if ($ville7) {
            $lieu6->setVille($ville7);
        }

        $manager->persist($lieu6);

        // Lieu 7 : Puy du Fou, Les Epesses
        $lieu7 = new Lieu();
        $lieu7->setNom('Puy du Fou');
        $lieu7->setRue('85590 Les Epesses');
        $lieu7->setLatitude(46.8951643);
        $lieu7->setLongitude(-0.9319349);
        $ville8 = $this->getReference('Les Epesses');

        if ($ville8) {
            $lieu7->setVille($ville8);
        }

        $manager->persist($lieu7);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            VilleFixtures::class,
        ];
    }
}
