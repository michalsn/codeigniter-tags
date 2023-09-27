<?php

namespace Tests\Support\Models;

use CodeIgniter\Model;
use Michalsn\CodeIgniterTags\Traits\HasTags;

class PostModel extends Model
{
    use HasTags;

    protected $table            = 'posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'body',
    ];
    protected $useTimestamps = true;
}
