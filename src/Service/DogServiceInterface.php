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

    /**
     * Save entity.
     *
     * @param Dog $dog Dog entity
     */
    public function save(Dog $dog): void;

    /**
     * Delete entity.
     *
     * @param Dog $dog Dog entity
     */
    public function delete(Dog $dog): void;
}