<?php
/**
 * Gender service.
 */

namespace App\Service;

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
     * Constructor.
     *
     * @param GenderRepository     $genderRepository Gender repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(GenderRepository $genderRepository, PaginatorInterface $paginator)
    {
        $this->genderRepository = $genderRepository;
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
            $this->genderRepository->queryAll(),
            $page,
            GenderRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
