<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/8/2019
 * Time: 12:16 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Role;

interface RoleServiceInterface
{
    public function findOneBy(string $name):?Role;

}