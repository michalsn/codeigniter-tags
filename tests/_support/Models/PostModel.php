<?php

namespace Tests\Support\Models;

use CodeIgniter\Model;
use Faker\Generator;
use Michalsn\CodeIgniterTags\Traits\HasTags;

class PostModel extends Model
{
    use HasTags;

    protected $table            = 'posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'body',
    ];
    protected $useTimestamps = true;

    public function fake(Generator &$faker)
    {
        return [
            'title' => $faker->sentence(),
            'body'  => $faker->paragraph(),
        ];
    }
}
