<?php

namespace Tests\Support\Entities;

use CodeIgniter\Entity\Entity;
use Michalsn\CodeIgniterTags\Traits\TaggableEntity;

class Image extends Entity
{
    use TaggableEntity;

    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'id'     => 'integer',
        'name'   => 'string',
        'width'  => 'integer',
        'height' => 'integer',
    ];
}
