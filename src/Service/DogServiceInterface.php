<?php
/**
 * Dog service interface.
 */

namespace App\Service;

use App\Entity\Dog;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface DogServiceInterface.
 */
interface DogServiceInterface
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