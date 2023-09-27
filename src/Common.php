<?php

use Michalsn\CodeIgniterTags\Entities\Tag;
use Myth\Collection\Collection;

if (! function_exists('convert_to_tags')) {
    /**
     * Returns tags Collection.
     */
    function convert_to_tags(array|string|Collection $tags): Collection
    {
        if ($tags instanceof Collection) {
            return $tags;
        }

        if (is_string($tags)) {
            $tags = explode(',', $tags);
        }

        return (new Collection($tags))->map(static function ($tag) {
            if ($tag instanceof Tag) {
                return $tag;
            }

            return new Tag(['name' => $tag]);
        });
    }
}
