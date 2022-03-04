<?php

namespace App\Repository;

use App\Entity\Rate;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rate[]    findAll()
 * @method Rate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rate::class);
    }

    /**
     * @param string|null $dateStart
     * @param string|null $dateEnd
     * @param string|null $code
     * @return int|array|string
     */
    public function getCourse(?string $dateStart, ?string $dateEnd, string $code)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('r.price', 'r.date')
            ->join('r.currency', 'c')
            ->andWhere('c.code = :code')->setParameter('code', $code);
        if ($dateStart) {
            $qb->andWhere('r.date >= :dateStart')->setParameter('dateStart', DateTime::createFromFormat('Y-m-d H:i:s', $dateStart));
        }
        if ($dateEnd) {
            $qb->andWhere('r.date <= :dateEnd')->setParameter('dateEnd', DateTime::createFromFormat('Y-m-d H:i:s', $dateEnd));
        }

        return $qb->getQuery()->getArrayResult();
    }
}
