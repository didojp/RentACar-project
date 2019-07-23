<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/8/2019
 * Time: 10:31 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;


class UserService implements UserServiceInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    /**
     * @param User $user
     * @return null|object|User
     */

    public function find(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    public function save(User $user): bool
    {
        return $this->userRepository->save($user);
    }

    public function update(User $user): bool
    {
        return $this->userRepository->update($user);
    }

    public function delete(User $user): bool
    {
        return $this->userRepository->delete($user);
    }


}


