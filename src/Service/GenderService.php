<?php
/**
 * Gender service.
 */

namespace App\Service;

use App\Entity\Gender;
use App\Repository\DogRepository;
use App\Repository\GenderRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class GenderService.
 */
class GenderService implements GenderServiceInterface
{
    /**
     * Gender repository.
     */
    private GenderRepository $genderRepository;

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
     * @param GenderRepository     $genderRepository Gender repository
     * @param DogRepository        $dogRepository    Dog repository
     * @param PaginatorInterface   $paginator        Paginator
     */
    public function __construct(GenderRepository $genderRepository, DogRepository $dogRepository, PaginatorInterface $paginator)
    {
        $this->genderRepository = $genderRepository;
        $this->dogRepository = $dogRepository;
        $this->paginator = $paginator;
    }

    /**
     * Find by id.
     *
     * @param int $id Gender id
     *
     * @return Gender|null Gender entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Gender
    {
        return $this->genderRepository->findOneById($id);
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
            $this->genderRepository->queryAll(),
            $page,
            GenderRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Gender $gender Gender entity
     */
    public function save(Gender $gender): void
    {
        $this->genderRepository->save($gender);
    }

    /**
     * Delete entity.
     *
     * @param Gender $gender Gender entity
     */
    public function delete(Gender $gender): void
    {
        $this->genderRepository->delete($gender);
    }

    /**
     * Can Gender be deleted?
     *
     * @param Gender $gender Gender entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Gender $gender): bool
    {
        try {
            $result = $this->dogRepository->countByGender($gender);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException $ex) {
            return false;
        }
    }
}
