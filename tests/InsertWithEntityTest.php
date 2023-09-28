<?php

namespace Tests;

use Tests\Support\Entities\Image;
use Tests\Support\Models\ImageModel;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class InsertWithEntityTest extends TestCase
{
    public function testSaveWithoutTags()
    {
        fake(ImageModel::class, [
            'name' => 'Test name',
        ]);

        $this->seeInDatabase('images', ['name' => 'Test name']);
    }

    public function testSaveWithEmptyTags()
    {
        fake(ImageModel::class, [
            'name' => 'Test name',
            'tags' => '',
        ]);

        $this->seeInDatabase('images', ['name' => 'Test name']);
        $this->dontSeeInDatabase('tags', ['id' => 1, 'name' => '']);
        $this->dontSeeInDatabase('taggable', ['taggable_id' => 1, 'taggable_type' => 'images']);
    }

    public function testSaveWithOneTagAsString()
    {
        fake(ImageModel::class, [
            'name' => 'Test name',
            'tags' => 'sample',
        ]);

        $this->seeInDatabase('images', ['name' => 'Test name']);
        $this->seeInDatabase('tags', ['id' => 1, 'name' => 'sample']);
        $this->seeInDatabase('taggable', ['tag_id' => 1, 'taggable_id' => 1, 'taggable_type' => 'images']);
    }

    public function testSaveWithManyTagsAsString()
    {
        fake(ImageModel::class, [
            'name' => 'Test name',
            'tags' => 'sample1,sample2',
        ]);

        $this->seeInDatabase('images', ['name' => 'Test name']);
        $this->seeInDatabase('tags', ['id' => 1, 'name' => 'sample1']);
        $this->seeInDatabase('tags', ['id' => 2, 'name' => 'sample2']);
        $this->seeInDatabase('taggable', ['tag_id' => 1, 'taggable_id' => 1, 'taggable_type' => 'images']);
        $this->seeInDatabase('taggable', ['tag_id' => 2, 'taggable_id' => 1, 'taggable_type' => 'images']);
    }

    public function testSaveWithManyTagsAsArray()
    {
        fake(ImageModel::class, [
            'name' => 'Test name',
            'tags' => ['sample1', 'sample2'],
        ]);

        $this->seeInDatabase('images', ['name' => 'Test name']);
        $this->seeInDatabase('tags', ['id' => 1, 'name' => 'sample1']);
        $this->seeInDatabase('tags', ['id' => 2, 'name' => 'sample2']);
        $this->seeInDatabase('taggable', ['tag_id' => 1, 'taggable_id' => 1, 'taggable_type' => 'images']);
        $this->seeInDatabase('taggable', ['tag_id' => 2, 'taggable_id' => 1, 'taggable_type' => 'images']);
    }

    public function testSaveWithManyTagsThenWithSetTag()
    {
        $image = fake(ImageModel::class, [
            'name' => 'Test name',
            'tags' => ['sample1', 'sample2'],
        ], false);
        /** @var Image $image */
        $image->setTags(['sample']);

        model(ImageModel::class)->insert($image);

        $this->seeInDatabase('images', ['name' => 'Test name']);
        $this->seeInDatabase('tags', ['id' => 1, 'name' => 'sample']);
        $this->seeInDatabase('taggable', ['tag_id' => 1, 'taggable_id' => 1, 'taggable_type' => 'images']);
    }
}
