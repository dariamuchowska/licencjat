<?php
/**
 * Dog service.
 */

namespace App\Service;

use App\Entity\Dog;
use App\Repository\DogRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * Breed service.
     */
    private BreedServiceInterface $breedService;

    /**
     * Size service.
     */
    private SizeServiceInterface $sizeService;

    /**
     * Gender service.
     */
    private GenderServiceInterface $genderService;

    /**
     * Constructor.
     *
     * @param DogRepository          $dogRepository Dog repository
     * @param BreedServiceInterface  $breedService  Breed service
     * @param SizeServiceInterface   $sizeService   Size service
     * @param GenderServiceInterface $genderService Gender service
     * @param PaginatorInterface     $paginator     Paginator
     */
    public function __construct(DogRepository $dogRepository, BreedServiceInterface $breedService, SizeServiceInterface $sizeService, GenderServiceInterface $genderService, PaginatorInterface $paginator)
    {
        $this->breedService = $breedService;
        $this->sizeService = $sizeService;
        $this->genderService = $genderService;
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
     * @param int                $page    Page number
     * @param array              $filters Filters
     * @param UserInterface|null $user    User
     *
     * @return PaginationInterface<string, mixed> Paginated list
     *
     * @throws NonUniqueResultException
     */
    public function getPaginatedList(int $page, array $filters = [], UserInterface $user = null): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->dogRepository->queryAll($filters, $user),
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

    /**
     * Prepare filters for the dogs list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     *
     * @throws NonUniqueResultException
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
}
