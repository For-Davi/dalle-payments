<?php

namespace Database\Seeders;

use App\Models\Projects;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        Projects::create([
            'name' => 'dalle-manage',
            'api_key' => 'dm_$dalle',
            'active' => 1
        ]);
    }
}
