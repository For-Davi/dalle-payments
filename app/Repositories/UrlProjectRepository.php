<?php

namespace App\Repositories;

use App\Models\UrlProject;

class UrlProjectRepository
{
    public function __construct(protected UrlProject $model) {}

    public function findByIdentifier($identifier)
    {
        return $this->model->where('identifier', $identifier)->first();
    }
}
