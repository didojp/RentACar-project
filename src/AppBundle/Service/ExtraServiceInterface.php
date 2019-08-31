<?php


namespace AppBundle\Service;


use AppBundle\Entity\Extra;

interface ExtraServiceInterface
{
    public function save(Extra $extra);
    public function update(Extra $extra):bool ;
    public function delete(Extra $extra):bool ;
    public function find(int $id);
    public function findAll();    

}