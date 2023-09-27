<?php

namespace Michalsn\CodeIgniterTags\Entities;

use CodeIgniter\Entity\Entity;

class Tag extends Entity
{
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'id' => 'integer',
    ];

    public function setName(string $name): static
    {
        $this->attributes['name'] = trim($name);
        $this->attributes['slug'] = mb_url_title($this->attributes['name'], '-', true);

        return $this;
    }
}
