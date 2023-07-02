<?php
/**
 * Dog repository.
 */

namespace App\Repository;

use App\Entity\Dog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DogRepository.
 *
 * @extends ServiceEntityRepository<Dog>
 *
 * @method Dog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dog[]    findAll()
 * @method Dog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 */
class DogRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 5;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dog::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('dog.name', 'ASC');
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('dog');
    }

    /**
     * Save entity.
     *
     * @param Dog $dog Dog entity
     */
    public function save(Dog $dog): void
    {
        $this->_em->persist($dog);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Dog $dog Dog entity
     */
    public function delete(Dog $dog): void
    {
        $this->_em->remove($dog);
        $this->_em->flush();
    }

//    /**
//     * @return Dog[] Returns an array of Dog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Dog
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
