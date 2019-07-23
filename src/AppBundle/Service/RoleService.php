<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/8/2019
 * Time: 12:20 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Role;
use AppBundle\Repository\RoleRepository;

class RoleService implements RoleServiceInterface
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository=$roleRepository;
    }

    /**
     * @param string $name
     * @return null|object|Role
     */
    public function findOneBy(string $name): ?Role
    {
        return $this->roleRepository->findOneBy(['name'=>$name]);
    }

}