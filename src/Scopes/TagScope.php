<?php

namespace Michalsn\CodeIgniterTags\Scopes;

use CodeIgniter\Database\BaseBuilder;
use Michalsn\CodeIgniterTags\Enums\ScopeTypes;
use Michalsn\CodeIgniterTags\Models\TagModel;

class TagScope
{
    public function __construct(protected array $tags, protected string $tagType, protected ScopeTypes $scopeType)
    {
    }

    public function getTagsIds(): ?array
    {
        $results = model(TagModel::class)->findByNames($this->tags);

        if (empty($results)) {
            return null;
        }

        return array_map('intval', array_column($results, 'id'));
    }

    public function getQuery(BaseBuilder $builder, array $tagIds): BaseBuilder
    {
        return match ($this->scopeType) {
            ScopeTypes::Only => $this->getOnlyTagsQuery($builder, $tagIds),
            ScopeTypes::Any  => $this->getAnyTagsQuery($builder, $tagIds),
        };
    }

    protected function getOnlyTagsQuery(BaseBuilder $builder, array $tagIds): BaseBuilder
    {
        return $builder
            ->select('taggable_id')
            ->from('taggable')
            ->where('taggable_type', $this->tagType)
            ->whereIn('tag_id', $tagIds)
            ->groupBy('taggable_id')
            ->having('COUNT(DISTINCT tag_id)', count($tagIds));
    }

    protected function getAnyTagsQuery(BaseBuilder $builder, array $tagIds): BaseBuilder
    {
        return $builder
            ->distinct()
            ->select('taggable_id')
            ->from('taggable')
            ->where('taggable_type', $this->tagType)
            ->whereIn('tag_id', $tagIds);
    }
}
