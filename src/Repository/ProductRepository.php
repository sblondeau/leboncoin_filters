<?php

namespace App\Repository;

use App\DTO\SearchDto;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    public function search(SearchDto $searchDto): array
    {
        $qb = $this->createQueryBuilder('p');

        if ($searchDto->search) {
            $qb->andWhere('p.name LIKE :search')
                ->setParameter('search', '%' . $searchDto->search . '%');
        }
        if ($searchDto->minPrice) {
            $qb->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice',  $searchDto->minPrice);
        }
        if ($searchDto->maxPrice) {
            $qb->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice',  $searchDto->maxPrice);
        }
        if ($searchDto->isUrgent) {
            $qb->andWhere('p.isUrgent = true');
        }
        return $qb->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
