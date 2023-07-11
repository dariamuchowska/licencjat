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
     * Find by id.
     *
     * @param int $id Gender id
     *
     * @return Gender|null Gender entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Gender;

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
     * @param Gender $gender Gender entity
     */
    public function save(Gender $gender): void;

    /**
     * Delete entity.
     *
     * @param Gender $gender Gender entity
     */
    public function delete(Gender $gender): void;

    /**
     * Can Gender be deleted?
     *
     * @param Gender $gender Gender entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Gender $gender): bool;
}
