<?php
/**
 * Dog service.
 */

namespace App\Service;

use App\Entity\Dog;
use App\Repository\DogRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class DogService.
 */
class DogService implements DogServiceInterface
{
    /**
     * Dog repository.
     */
    private DogRepository $dogRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param DogRepository     $dogRepository Dog repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(DogRepository $dogRepository, PaginatorInterface $paginator)
    {
        $this->dogRepository = $dogRepository;
        $this->paginator = $paginator;
    }

    /**
     * Find by id.
     *
     * @param int $id Dog id
     *
     * @return Dog|null Dog entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Dog
    {
        return $this->dogRepository->findOneById($id);
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->dogRepository->queryAll(),
            $page,
            DogRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Dog $dog Dog entity
     */
    public function save(Dog $dog): void
    {
        $this->dogRepository->save($dog);
    }

    /**
     * Delete entity.
     *
     * @param Dog $dog Dog entity
     */
    public function delete(Dog $dog): void
    {
        $this->dogRepository->delete($dog);
    }
}
