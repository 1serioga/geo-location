<?php

namespace App\Repository;

use App\Entity\IpLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IpLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method IpLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method IpLocation[]    findAll()
 * @method IpLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IpLocationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IpLocation::class);
    }
}
