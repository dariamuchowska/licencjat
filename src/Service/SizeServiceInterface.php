<?php
/**
 * Size service interface.
 */

namespace App\Service;

use App\Entity\Size;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface SizeServiceInterface.
 */
interface SizeServiceInterface
{
    /**
     * Find by id.
     *
     * @param int $id Size id
     *
     * @return Size|null Size entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Size;

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Size $size Size entity
     */
    public function save(Size $size): void;
}
