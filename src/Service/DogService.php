<?php
/**
 * Dogservice.
 */

namespace App\Service;

use App\Repository\DogRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BookService.
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
     * @param DogRepository      $dogRepository  Dog repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(DogRepository $dogRepository, PaginatorInterface $paginator)
    {
        $this->dogRepository = $dogRepository;
        $this->paginator = $paginator;
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
}