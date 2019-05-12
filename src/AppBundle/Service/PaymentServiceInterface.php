<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/9/2019
 * Time: 4:04 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Payment;

interface PaymentServiceInterface
{
    public function find(int $id);
    public function findAll();
    public function save(Payment $payment);
    public function update(Payment $payment);
    public function delete(Payment $payment);

}