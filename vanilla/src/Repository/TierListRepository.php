<?php

namespace App\Repository;

use App\Entity\TierList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TierList>
 *
 * @method TierList|null find($id, $lockMode = null, $lockVersion = null)
 * @method TierList|null findOneBy(array $criteria, array $orderBy = null)
 * @method TierList[]    findAll()
 * @method TierList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TierListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TierList::class);
    }

    public function save(TierList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TierList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
