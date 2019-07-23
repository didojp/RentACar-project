<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/8/2019
 * Time: 10:08 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;

interface UserServiceInterface
{
    public function find(int $id):?User;
    public function findAll():array;
    public function save(User $user):bool;
    public function update(User $user):bool;
    public function delete(User $user):bool;

}