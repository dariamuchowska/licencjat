<?php
/**
 * Dog repository.
 */

namespace App\Repository;

use App\Entity\Breed;
use App\Entity\Dog;
use App\Entity\Gender;
use App\Entity\Size;
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
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial dog.{id, name, age, description}',
                'partial breed.{id, name}',
                'partial size.{id, name}',
                'partial gender.{id, name}'
            )
            ->join('dog.breed', 'breed')
            ->join('dog.size', 'size')
            ->join('dog.gender', 'gender')
            ->orderBy('dog.id', 'ASC');
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

    /**
     * Count dogs by breed.
     *
     * @param Breed $breed Breed
     *
     * @return int Number of dogs in breed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByBreed(Breed $breed): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('dog.id'))
            ->where('dog.breed = :breed')
            ->setParameter(':breed', $breed)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Count dogs by gender.
     *
     * @param Gender $gender Gender
     *
     * @return int Number of dogs in gender
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByGender(Gender $gender): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('dog.id'))
            ->where('dog.gender = :gender')
            ->setParameter(':gender', $gender)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Count dogs by size.
     *
     * @param Size $size Size
     *
     * @return int Number of dogs in size
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countBySize(Size $size): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('dog.id'))
            ->where('dog.size = :size')
            ->setParameter(':size', $size)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
