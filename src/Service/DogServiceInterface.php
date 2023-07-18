<?php
/**
 * Dog service interface.
 */

namespace App\Service;

use App\Entity\Dog;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface DogServiceInterface.
 */
interface DogServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param array              $filters Filters
     * @param UserInterface|null $user    User
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, array $filters = [], UserInterface $user = null): PaginationInterface;

    /**
     * Filter by author.
     *
     * @param int  $page   Page number
     * @param User $author Author
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getAuthorList(int $page, User $author): PaginationInterface;

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