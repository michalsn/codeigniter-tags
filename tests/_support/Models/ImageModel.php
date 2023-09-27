<?php

namespace Tests\Support\Models;

use CodeIgniter\Model;
use Faker\Generator;
use Michalsn\CodeIgniterTags\Traits\HasTags;
use Tests\Support\Entities\Image;

class ImageModel extends Model
{
    use HasTags;

    protected $table            = 'images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Image::class;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'width', 'height',
    ];
    protected $useTimestamps = true;

    public function fake(Generator &$faker)
    {
        return [
            'name'   => $faker->word() . '.jpg',
            'width'  => $faker->numberBetween(100, 200),
            'height' => $faker->numberBetween(100, 200),
        ];
    }
}
