<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Tests\Support\Models\ImageModel;

class TestImageSeeder extends Seeder
{
    public function run(): void
    {
        helper('test');

        fake(ImageModel::class, ['tags' => 'sample tag']);

        fake(ImageModel::class, ['tags' => 'sample 1, sample 2']);

        fake(ImageModel::class, ['tags' => 'sample 1, sample 2']);

        fake(ImageModel::class, ['tags' => 'sample 1']);

        fake(ImageModel::class, ['tags' => 'sample 2']);

        fake(ImageModel::class);
    }
}
