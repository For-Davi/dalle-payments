<?php

namespace App\Modules\Asaas\Repositories;

use App\Modules\Asaas\Models\AsaasPaymentInfo;
use App\Repositories\Base\BaseRepository;
use Override;

class AsaasPaymentInfoRepository extends BaseRepository
{
    public function __construct(AsaasPaymentInfo $model)
    {
        parent::__construct($model);
    }

    public function deleteByPaymentId($id)
    {
        $paymentInfo = $this->findByPaymentID($id);
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
