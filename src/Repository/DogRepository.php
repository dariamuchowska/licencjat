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
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class DogRepository.
 *
 * @method Dog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dog[]    findAll()
 * @method Dog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Dog>
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
    public const PAGINATOR_ITEMS_PER_PAGE = 8;

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
     * Query dogs by author.
     *
     * @param UserInterface         $user    User entity
     * @param array<string, object> $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryByAuthor(UserInterface $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('dog.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * Query all records.
     *
     * @param array<string, object> $filters Filters
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(array $filters): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial dog.{id, name, age, description, photoFilename}',
                'partial breed.{id, name}',
                'partial size.{id, name}',
                'partial gender.{id, name}'
            )
            ->join('dog.breed', 'breed')
            ->join('dog.size', 'size')
            ->join('dog.gender', 'gender')
            ->orderBy('dog.id', 'ASC');

        return $this->applyFiltersToList($queryBuilder, $filters);
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

    /**
     * Prepare filters for the dogs list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['breed_id'])) {
            $breed = $this->breedService->findOneById($filters['breed_id']);
            if (null !== $breed) {
                $resultFilters['breed'] = $breed;
            }
        }

        if (!empty($filters['size_id'])) {
            $size = $this->sizeService->findOneById($filters['size_id']);
            if (null !== $size) {
                $resultFilters['size'] = $size;
            }
        }

        if (!empty($filters['gender_id'])) {
            $gender = $this->genderService->findOneById($filters['gender_id']);
            if (null !== $gender) {
                $resultFilters['gender'] = $gender;
            }
        }

        return $resultFilters;
    }

    /**
     * Apply filters to paginated list.
     *
     * @param QueryBuilder          $queryBuilder Query builder
     * @param array<string, object> $filters      Filters array
     *
     * @return QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['breed']) && $filters['breed'] instanceof Breed) {
            $queryBuilder->andWhere('breed = :breed')
                ->setParameter('breed', $filters['breed']);
        }

        if (isset($filters['size']) && $filters['size'] instanceof Size) {
            $queryBuilder->andWhere('size = :size')
                ->setParameter('size', $filters['size']);
        }

        if (isset($filters['gender']) && $filters['gender'] instanceof Gender) {
            $queryBuilder->andWhere('gender = :gender')
                ->setParameter('gender', $filters['gender']);
        }

        return $queryBuilder;
    }
}
