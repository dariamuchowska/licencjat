<?php
/**
 * Breed service.
 */

namespace App\Service;

use App\Entity\Breed;
use App\Repository\BreedRepository;
use App\Repository\DogRepository;
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
     * Dog repository.
     */
    private DogRepository $dogRepository;

    /**
     * Constructor.
     *
     * @param BreedRepository     $breedRepository   Breed repository
     * @param DogRepository       $dogRepository     Dog repository
     * @param PaginatorInterface  $paginator         Paginator
     */
    public function __construct(BreedRepository $breedRepository, DogRepository $dogRepository, PaginatorInterface $paginator)
    {
        $this->breedRepository = $breedRepository;
        $this->dogRepository = $dogRepository;
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

    /**
     * Delete entity.
     *
     * @param Breed $breed Breed entity
     */
    public function delete(Breed $breed): void
    {
        $this->breedRepository->delete($breed);
    }

    /**
     * Can Breed be deleted?
     *
     * @param Breed $breed Breed entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Breed $breed): bool
    {
        try {
            $result = $this->dogRepository->countByBreed($breed);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException $ex) {
            return false;
        }
    }
}
