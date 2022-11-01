<?php

namespace App\Repository;

use App\Entity\TierListRank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TierListRank>
 *
 * @method TierListRank|null find($id, $lockMode = null, $lockVersion = null)
 * @method TierListRank|null findOneBy(array $criteria, array $orderBy = null)
 * @method TierListRank[]    findAll()
 * @method TierListRank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TierListRankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TierListRank::class);
    }

    public function save(TierListRank $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TierListRank $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
