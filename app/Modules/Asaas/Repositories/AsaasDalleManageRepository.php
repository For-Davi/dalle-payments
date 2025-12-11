<?php

namespace App\Modules\Asaas\Repositories;

use App\Modules\Asaas\Models\AsaasDalleManage;
use App\Repositories\Base\BaseRepository;

class AsaasDalleManageRepository extends BaseRepository
{
    public function __construct(AsaasDalleManage $model)
    {
        parent::__construct($model);
    }
}
