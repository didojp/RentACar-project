<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/9/2019
 * Time: 4:06 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Payment;
use AppBundle\Repository\PaymentRepository;

class PaymentService implements PaymentServiceInterface
{
    private $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository=$paymentRepository;
    }

    /**
     * @param int $id
     * @return null|object|Payment
     */
    public function find(int $id):?Payment
    {
        return $this->paymentRepository->find($id);
    }

    public function findAll():array
    {
        return $this->paymentRepository->findAll();
    }

    public function save(Payment $payment)
    {
        return $this->paymentRepository->save($payment);
    }

    public function update(Payment $payment)
    {
        return $this->paymentRepository->update($payment);
    }

    public function delete(Payment $payment)
    {
        return $this->paymentRepository->delete($payment);
    }


}