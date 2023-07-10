<?php
/**
 * Breed service.
 */

namespace App\Service;

use App\Entity\Breed;
use App\Repository\BreedRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BreedService.
 */
class BreedService implements BreedServiceInterface
{
    /**
     * Breed repository.
     */
    private BreedRepository $breedRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param BreedRepository     $breedRepository Breed repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(BreedRepository $breedRepository, PaginatorInterface $paginator)
    {
        $this->breedRepository = $breedRepository;
        $this->paginator = $paginator;
    }

    /**
     * Find by id.
     *
     * @param int $id Breed id
     *
     * @return Breed|null Breed entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Breed
    {
        return $this->breedRepository->findOneById($id);
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
            $this->breedRepository->queryAll(),
            $page,
            BreedRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Breed $breed Breed entity
     */
    public function save(Breed $breed): void
    {
        $this->breedRepository->save($breed);
    }
}
