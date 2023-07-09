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
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

}
