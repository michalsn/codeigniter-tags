<?php

namespace Michalsn\CodeIgniterTags\Traits;

use Myth\Collection\Collection;

trait TaggableEntity
{
    public function getTags(): ?Collection
    {
        if (! array_key_exists('tags', $this->attributes)) {
            return null;
        }

        return $this->getTagsCollection();
    }

    public function setTags(array|string|Collection $tags): static
    {
        if (is_string($tags)) {
            $tags = explode(',', $tags);
        }

        $this->attributes['tags'] = convert_to_tags($tags)->unique('name');

        return $this;
    }

    public function addTags(array|Collection $tags): static
    {
        $this->attributes['tags'] = $this->getTagsCollection()->merge(convert_to_tags($tags))->unique('name');

        return $this;
    }

    public function removeTags(array|Collection $tags): static
    {
        $this->attributes['tags'] = $this->getTagsCollection()->diff(convert_to_tags($tags), 'name');

        return $this;
    }

    private function getTagsCollection(): Collection
    {
        if (! isset($this->attributes['tags'])) {
            $this->attributes['tags'] = new Collection([]);
        }

        return $this->attributes['tags'];
    }
}
