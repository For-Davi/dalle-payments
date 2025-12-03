<?php

namespace App\Modules\Asaas\Repositories;

use App\Modules\Asaas\Models\AsaasDalleManage;

class AsaasDalleManageRepository
{
    public function __construct(protected AsaasDalleManage $model) {}

    public function findById($id)
    {
        return $this->model->where('payment_id', $id)->first();
    }  

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $webhookData = $this->findById($id);
        if ($webhookData) {
            $webhookData->update($data);

            return $webhookData;
        }

        return null;
    }
}
