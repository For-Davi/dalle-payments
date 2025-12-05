<?php

namespace Database\Seeders;

use App\Models\UrlProject;
use Illuminate\Database\Seeder;

class UrlProjectSeeder extends Seeder
{
    public function run()
    {
        UrlProject::create(['base_url' => 'http://host.docker.internal:8000/api', 'identifier' => 'dalle_manage']);
    }

    public function rollback()
    {
        UrlProject::whereIn('identifier', [
            'dalle_manage',
        ])->delete();
    }
}
