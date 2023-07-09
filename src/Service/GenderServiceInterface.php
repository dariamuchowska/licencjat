<?php
/**
 * Gender service interface.
 */

namespace App\Service;

use App\Entity\Gender;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface GenderServiceInterface.
 */
interface GenderServiceInterface
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
