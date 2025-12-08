<?php

namespace App\Modules\Asaas\Repositories;

use App\Modules\Asaas\Models\AsaasPaymentInfo;

class AsaasPaymentInfoRepository
{
    public function __construct(protected AsaasPaymentInfo $model) {}

    public function findById($id)
    {
        return $this->model->where('payment_id', $id)->first();
    }

    public function findByUserId($id)
    {
        return $this->model->where('user_id', $id)->first();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $paymentInfo = $this->findByUserId($id);
        if ($paymentInfo) {
            $paymentInfo->update($data);

            return $paymentInfo;
        }

        return null;
    }

    public function deleteByPaymentId($id)
    {
        $paymentInfo = $this->findById($id);
        if ($paymentInfo) {

            return $paymentInfo->delete();
        }

        return true;
    }

    public function deleteByUserId($id)
    {
        $paymentInfo = $this->findByUserId($id);
        if ($paymentInfo) {

            return $paymentInfo->delete();
        }

        return true;
    }
}
