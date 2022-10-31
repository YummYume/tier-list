<?php

namespace App\Repository;

use App\Entity\TierListItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TierListItem>
 *
 * @method TierListItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method TierListItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method TierListItem[]    findAll()
 * @method TierListItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TierListItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TierListItem::class);
    }

    public function save(TierListItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TierListItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
