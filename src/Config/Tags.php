<?php

namespace Michalsn\CodeIgniterTags\Config;

use CodeIgniter\Config\BaseConfig;

class Tags extends BaseConfig
{
    /**
     * Whether unused tags will be
     * removed automatically upon update.
     */
    public bool $cleanupUnusedTags = true;
}
