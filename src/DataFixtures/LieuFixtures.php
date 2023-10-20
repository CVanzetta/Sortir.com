<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Annotation\Groups;
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

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            VilleFixtures::class,
        ];
    }
}
