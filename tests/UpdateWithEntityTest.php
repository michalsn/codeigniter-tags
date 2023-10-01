<?php

namespace Tests;

use Myth\Collection\Collection;
use Tests\Support\Database\Seeds\TestImageSeeder;
use Tests\Support\Entities\Image;
use Tests\Support\Models\ImageModel;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class UpdateWithEntityTest extends TestCase
{
    protected $seed = TestImageSeeder::class;

    public function testFindWithoutTag()
    {
        $model = model(ImageModel::class);
        /** @var Image $image */
        $image = $model->find(1);

        $this->assertNull($image->tags);
    }

    public function testFindWithTags()
    {
        $model = model(ImageModel::class);
        /** @var Image $image */
        $image = $model->withTags()->find(1);

        $this->assertInstanceOf(Collection::class, $image->tags);
        $this->assertCount(1, $image->tags);
        $this->assertSame('sample tag', $image->tags[0]->name);
        $this->assertSame('sample-tag', $image->tags[0]->slug);
    }

    public function testFindWithTagsAsArray()
    {
        $model = model(ImageModel::class);
        /** @var Image $image */
        $image = $model->asArray()->withTags()->find(1);

        $this->assertInstanceOf(Collection::class, $image['tags']);
        $this->assertCount(1, $image['tags']);
        $this->assertSame('sample tag', $image['tags'][0]->name);
        $this->assertSame('sample-tag', $image['tags'][0]->slug);
    }

    public function testFindWithTagsAndAddTag()
    {
        $model = model(ImageModel::class);
        /** @var Image $image */
        $image = $model->withTags()->find(1);

        $this->assertInstanceOf(Collection::class, $image->tags);
        $this->assertCount(1, $image->tags);

        $image->addTags(['second tag']);
        $model->save($image);

        /** @var Image $image */
        $image = $model->withTags()->find(1);

        $this->assertInstanceOf(Collection::class, $image->tags);
        $this->assertCount(2, $image->tags);
        $this->assertSame('sample tag', $image->tags[0]->name);
        $this->assertSame('sample-tag', $image->tags[0]->slug);
        $this->assertSame('second tag', $image->tags[1]->name);
        $this->assertSame('second-tag', $image->tags[1]->slug);
    }

    public function testFindWithTagsAndRemoveTag()
    {
        $model = model(ImageModel::class);
        /** @var Image $image */
        $image = $model->withTags()->find(2);

        $this->assertInstanceOf(Collection::class, $image->tags);
        $this->assertCount(2, $image->tags);

        $image->removeTags(['sample 1']);
        $model->save($image);

        /** @var Image $image */
        $image = $model->withTags()->find(2);
        $this->assertInstanceOf(Collection::class, $image->tags);
        $this->assertCount(1, $image->tags);

        $this->assertSame('sample 2', $image->tags[0]->name);
        $this->assertSame('sample-2', $image->tags[0]->slug);
    }

    public function testFindWithTagsAndSetTag()
    {
        $model = model(ImageModel::class);
        /** @var Image $image */
        $image = $model->withTags()->find(2);

        $this->assertInstanceOf(Collection::class, $image->tags);
        $this->assertCount(2, $image->tags);

        $this->assertSame('sample 1', $image->tags[0]->name);
        $this->assertSame('sample-1', $image->tags[0]->slug);
        $this->assertSame('sample 2', $image->tags[1]->name);
        $this->assertSame('sample-2', $image->tags[1]->slug);

        $image->setTags(['sample 1']);
        $model->save($image);

        /** @var Image $image */
        $image = $model->withTags()->find(2);
        $this->assertInstanceOf(Collection::class, $image->tags);
        $this->assertCount(1, $image->tags);

        $this->assertSame('sample 1', $image->tags[0]->name);
        $this->assertSame('sample-1', $image->tags[0]->slug);
    }

    public function testFindWithOnlyTags()
    {
        $model  = model(ImageModel::class);
        $images = $model->withAllTags(['sample 1', 'sample 2'])->findAll();

        $this->assertCount(2, $images);

        $this->assertInstanceOf(Collection::class, $images[0]->tags);
        $this->assertCount(2, $images[0]->tags);

        $this->assertInstanceOf(Collection::class, $images[1]->tags);
        $this->assertCount(2, $images[1]->tags);
    }

    public function testFindWithAnyTags()
    {
        $model  = model(ImageModel::class);
        $images = $model->withAnyTags(['sample 1', 'sample 2'])->findAll();

        $this->assertCount(4, $images);

        $this->assertInstanceOf(Collection::class, $images[0]->tags);
        $this->assertCount(2, $images[0]->tags);

        $this->assertInstanceOf(Collection::class, $images[1]->tags);
        $this->assertCount(2, $images[1]->tags);

        $this->assertInstanceOf(Collection::class, $images[2]->tags);
        $this->assertCount(1, $images[2]->tags);

        $this->assertInstanceOf(Collection::class, $images[3]->tags);
        $this->assertCount(1, $images[3]->tags);
    }

    public function testFindAndSaveWithNoTags()
    {
        $model = model(ImageModel::class);
        /** @var Image $image */
        $image = $model->find(6);

        $this->assertNull($image->tags);

        $image->name = 'sample.jpeg';
        $model->save($image);

        $this->dontSeeInDatabase('taggable', ['taggable_id' => 6, 'taggable_type' => 'images']);
    }
}
