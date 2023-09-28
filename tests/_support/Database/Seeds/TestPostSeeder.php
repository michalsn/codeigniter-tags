<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Tests\Support\Models\PostModel;

class TestPostSeeder extends Seeder
{
    public function run(): void
    {
        helper('test');

        fake(PostModel::class, ['tags' => 'sample tag']);

        fake(PostModel::class, ['tags' => 'sample 1, sample 2']);

        fake(PostModel::class, ['tags' => 'sample 1, sample 2']);

        fake(PostModel::class, ['tags' => 'sample 1']);

        fake(PostModel::class, ['tags' => 'sample 2']);

        fake(PostModel::class);
    }
}
