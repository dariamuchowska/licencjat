<?php
/**
 * User service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\DogRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class UserService.
 */
class UserService implements UserServiceInterface
{
    /**
     * UserRepository.
     */
    private UserRepository $userRepository;

    /**
     * PaginatorInterface.
     */
    private PaginatorInterface $paginator;

    /**
     * Dog Repository.
     */
    private DogRepository $dogRepository;

    /**
     * Constructor.
     *
     * @param UserRepository     $userRepository User repository
     * @param DogRepository     $dogRepository Dog repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(UserRepository $userRepository, DogRepository $dogRepository, PaginatorInterface $paginator)
    {
        $this->userRepository = $userRepository;
        $this->paginator = $paginator;
        $this->dogRepository = $dogRepository;
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
            $this->userRepository->queryAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Can User be deleted?
     *
     * @param User $user User entity
     *
     * @return bool Result
     */
    public function canBeDeleted(User $user): bool
    {
        try {
            $result = $this->dogRepository->countByAuthor($user);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException $ex) {
            return false;
        }
    }

    /**
     * Save entity.
     *
     * @param User $user User entity
     */
    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }

    /**
     * Delete entity.
     *
     * @param User $user User entity
     */
    public function delete(User $user): void
    {
        $this->userRepository->delete($user);
    }
}