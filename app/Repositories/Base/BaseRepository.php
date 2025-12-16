<?php

namespace App\Repositories\Base;

use App\Modules\Asaas\Models\AsaasDalleManage;
use App\Modules\Asaas\Models\AsaasPaymentInfo;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data, array $relations = []): ?Model
    {
        if ($this->model instanceof AsaasDalleManage) {
            $record = $this->findByPaymentID($id, $relations);
        } elseif ($this->model instanceof AsaasPaymentInfo) {
            $record = $this->findByUserId($id, $relations);
        } else {
            $record = $this->findById($id, $relations);
        }

        if (! $record) {
            return null;
        }

        $record->update($data);

        return $record;
    }

    public function getAllByEnterprise(array $relations = [], array $columns = ['*'], array $filters = [])
    {
        $query = $this->model->query();

        if (! empty($relations)) {
            $query->with($relations);
        }

        if (! empty($filters)) {
            foreach ($filters as $field => $value) {
                $query->where($field, $value);
            }
        }

        return $query->get($columns);
    }

    public function getAllByUser(array $relations = [])
    {
        $query = $this->model->query();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->get();
    }

    public function findById(int $id, array $relations = []): ?Model
    {
        $query = $this->model->newQuery();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->find($id);
    }

    public function findByPaymentID($id)
    {
        return $this->model->where('payment_id', $id)->first();
    }

    public function findByUserId($id)
    {
        return $this->model->where('user_id', $id)->first();
    }
}
