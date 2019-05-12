<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/9/2019
 * Time: 3:22 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Deal;

interface DealServiceInterface
{
    public function find(int $id);
    public function findAll();
    public function save(Deal $deal);
    public function update(Deal $deal);
    public function delete(Deal $deal);

}