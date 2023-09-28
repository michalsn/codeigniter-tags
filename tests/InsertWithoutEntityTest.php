<?php

namespace Tests;

use Tests\Support\Models\PostModel;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class InsertWithoutEntityTest extends TestCase
{
    public function testSaveWithoutTags()
    {
        fake(PostModel::class, [
            'title' => 'Test name',
        ]);

        $this->seeInDatabase('posts', ['title' => 'Test name']);
    }

    public function testSaveWithEmptyTags()
    {
        fake(PostModel::class, [
            'title' => 'Test name',
            'tags'  => '',
        ]);

        $this->seeInDatabase('posts', ['title' => 'Test name']);
        $this->dontSeeInDatabase('tags', ['id' => 1, 'name' => '']);
        $this->dontSeeInDatabase('taggable', ['taggable_id' => 1, 'taggable_type' => 'posts']);
    }

    public function testSaveWithOneTagAsString()
    {
        fake(PostModel::class, [
            'title' => 'Test name',
            'tags'  => 'sample',
        ]);

        $this->seeInDatabase('posts', ['title' => 'Test name']);
        $this->seeInDatabase('tags', ['id' => 1, 'name' => 'sample']);
        $this->seeInDatabase('taggable', ['tag_id' => 1, 'taggable_id' => 1, 'taggable_type' => 'posts']);
    }

    public function testSaveWithManyTagsAsString()
    {
        fake(PostModel::class, [
            'title' => 'Test name',
            'tags'  => 'sample1,sample2',
        ]);

        $this->seeInDatabase('posts', ['title' => 'Test name']);
        $this->seeInDatabase('tags', ['id' => 1, 'name' => 'sample1']);
        $this->seeInDatabase('tags', ['id' => 2, 'name' => 'sample2']);
        $this->seeInDatabase('taggable', ['tag_id' => 1, 'taggable_id' => 1, 'taggable_type' => 'posts']);
        $this->seeInDatabase('taggable', ['tag_id' => 2, 'taggable_id' => 1, 'taggable_type' => 'posts']);
    }

    public function testSaveWithManyTagsAsArray()
    {
        fake(PostModel::class, [
            'title' => 'Test name',
            'tags'  => ['sample1', 'sample2'],
        ]);

        $this->seeInDatabase('posts', ['title' => 'Test name']);
        $this->seeInDatabase('tags', ['id' => 1, 'name' => 'sample1']);
        $this->seeInDatabase('tags', ['id' => 2, 'name' => 'sample2']);
        $this->seeInDatabase('taggable', ['tag_id' => 1, 'taggable_id' => 1, 'taggable_type' => 'posts']);
        $this->seeInDatabase('taggable', ['tag_id' => 2, 'taggable_id' => 1, 'taggable_type' => 'posts']);
    }
}
