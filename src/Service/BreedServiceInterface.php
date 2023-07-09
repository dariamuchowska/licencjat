<?php
/**
 * Breed service interface.
 */

namespace App\Service;

use App\Entity\Breed;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface BreedServiceInterface.
 */
interface BreedServiceInterface
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
