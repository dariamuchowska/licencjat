<?php
/**
 * Size service.
 */

namespace App\Service;

use App\Entity\Size;
use App\Repository\SizeRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class SizeService.
 */
class SizeService implements SizeServiceInterface
{
    /**
     * Size repository.
     */
    private SizeRepository $sizeRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param SizeRepository     $sizeRepository Size repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(SizeRepository $sizeRepository, PaginatorInterface $paginator)
    {
        $this->sizeRepository = $sizeRepository;
        $this->paginator = $paginator;
    }

    /**
     * Find by id.
     *
     * @param int $id Size id
     *
     * @return Size|null Size entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Size
    {
        return $this->sizeRepository->findOneById($id);
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
            $this->sizeRepository->queryAll(),
            $page,
            SizeRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Size $size Size entity
     */
    public function save(Size $size): void
    {
        $this->sizeRepository->save($size);
    }
}
