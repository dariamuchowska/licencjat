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
     * Find by id.
     *
     * @param int $id Breed id
     *
     * @return Breed|null Breed entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Breed;

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
     * @param Breed $breed Breed entity
     */
    public function save(Breed $breed): void;

    /**
     * Delete entity.
     *
     * @param Breed $breed Breed entity
     */
    public function delete(Breed $breed): void;

}
