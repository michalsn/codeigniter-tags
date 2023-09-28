<?php

namespace Tests;

use Michalsn\CodeIgniterTags\Entities\Tag;
use Myth\Collection\Collection;
use Tests\Support\Database\Seeds\TestPostSeeder;
use Tests\Support\Models\PostModel;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class UpdateWithoutEntityTest extends TestCase
{
    protected $seed = TestPostSeeder::class;

    public function testFindWithoutTag()
    {
        $model = model(PostModel::class);
        $post  = $model->find(1);

        $this->assertObjectNotHasProperty('tags', $post);
    }

    public function testFindWithTags()
    {
        $model = model(PostModel::class);
        $post  = $model->withTags()->find(1);

        $this->assertInstanceOf(Collection::class, $post->tags);
        $this->assertCount(1, $post->tags);
        $this->assertSame('sample tag', $post->tags[0]->name);
        $this->assertSame('sample-tag', $post->tags[0]->slug);
    }

    public function testFindWithTagsAndAddTag()
    {
        $model = model(PostModel::class);
        $post  = $model->withTags()->find(1);

        $this->assertInstanceOf(Collection::class, $post->tags);
        $this->assertCount(1, $post->tags);

        // $image->addTags(['second tag']);
        $post->tags->push(new Tag(['name' => 'second tag']));
        $model->save($post);

        $post = $model->withTags()->find(1);

        $this->assertInstanceOf(Collection::class, $post->tags);
        $this->assertCount(2, $post->tags);
        $this->assertSame('sample tag', $post->tags[0]->name);
        $this->assertSame('sample-tag', $post->tags[0]->slug);
        $this->assertSame('second tag', $post->tags[1]->name);
        $this->assertSame('second-tag', $post->tags[1]->slug);
    }

    public function testFindWithTagsAndRemoveTag()
    {
        $model = model(PostModel::class);
        $post  = $model->withTags()->find(2);

        $this->assertInstanceOf(Collection::class, $post->tags);
        $this->assertCount(2, $post->tags);

        // $image->removeTags(['sample 1']);
        $post->tags = $post->tags->diff(convert_to_tags('sample 1'), 'name');
        $model->save($post);

        $post = $model->withTags()->find(2);
        $this->assertInstanceOf(Collection::class, $post->tags);
        $this->assertCount(1, $post->tags);

        $this->assertSame('sample 2', $post->tags[0]->name);
        $this->assertSame('sample-2', $post->tags[0]->slug);
    }

    public function testFindWithTagsAndSetTag()
    {
        $model = model(PostModel::class);
        $post  = $model->withTags()->find(2);

        $this->assertInstanceOf(Collection::class, $post->tags);
        $this->assertCount(2, $post->tags);

        $this->assertSame('sample 1', $post->tags[0]->name);
        $this->assertSame('sample-1', $post->tags[0]->slug);
        $this->assertSame('sample 2', $post->tags[1]->name);
        $this->assertSame('sample-2', $post->tags[1]->slug);

        // $image->setTags(['sample 1']);
        $post->tags = 'sample 1';
        $model->save($post);

        $post = $model->withTags()->find(2);
        $this->assertInstanceOf(Collection::class, $post->tags);
        $this->assertCount(1, $post->tags);

        $this->assertSame('sample 1', $post->tags[0]->name);
        $this->assertSame('sample-1', $post->tags[0]->slug);
    }

    public function testFindWithOnlyTags()
    {
        $model = model(PostModel::class);
        $posts = $model->withOnlyTags(['sample 1', 'sample 2'])->findAll();

        $this->assertCount(2, $posts);

        $this->assertInstanceOf(Collection::class, $posts[0]->tags);
        $this->assertCount(2, $posts[0]->tags);

        $this->assertInstanceOf(Collection::class, $posts[1]->tags);
        $this->assertCount(2, $posts[1]->tags);
    }

    public function testFindWithAnyTags()
    {
        $model = model(PostModel::class);
        $posts = $model->withAnyTags(['sample 1', 'sample 2'])->findAll();

        $this->assertCount(4, $posts);

        $this->assertInstanceOf(Collection::class, $posts[0]->tags);
        $this->assertCount(2, $posts[0]->tags);

        $this->assertInstanceOf(Collection::class, $posts[1]->tags);
        $this->assertCount(2, $posts[1]->tags);

        $this->assertInstanceOf(Collection::class, $posts[2]->tags);
        $this->assertCount(1, $posts[2]->tags);

        $this->assertInstanceOf(Collection::class, $posts[3]->tags);
        $this->assertCount(1, $posts[3]->tags);
    }

    public function testFindAndSaveWithNoTags()
    {
        $model = model(PostModel::class);
        $post  = $model->find(6);

        $this->assertObjectNotHasProperty('tags', $post);

        $post->title = 'Sample title';
        $model->save($post);

        $this->dontSeeInDatabase('taggable', ['taggable_id' => 6, 'taggable_type' => 'posts']);
    }
}
