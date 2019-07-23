<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/7/2019
 * Time: 10:42 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Transmision;

interface TransmisionServiceInterface
{
    public function find(int $id);
    public function findAll();
    public function save(Transmision $transmision):bool ;
    public function update(Transmision $transmision):bool ;
    public function delete(Transmision $transmision):bool ;

}

