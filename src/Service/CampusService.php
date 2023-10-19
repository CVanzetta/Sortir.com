<?php
// CampusService.php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Campus;

class CampusService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCampusByName($name)
    {
        $campusRepository = $this->entityManager->getRepository(Campus::class);
        return $campusRepository->findOneBy(['nom' => $name]);
    }
}
