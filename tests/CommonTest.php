<?php

namespace Tests;

use Michalsn\CodeIgniterTags\Entities\Tag;
use Myth\Collection\Collection;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class CommonTest extends TestCase
{
    public function testConvertToTagsWithTag()
    {
        $tag  = new Tag(['name' => 'test']);
        $tags = convert_to_tags($tag);

        $this->assertEquals(
            [$tag],
            $tags->toArray()
        );
    }

    public function testConvertToTagsWithCollection()
    {
        $tag        = new Tag(['name' => 'test']);
        $collection = new Collection([$tag, $tag]);
        $tags       = convert_to_tags($collection);

        $this->assertEquals(
            [$tag, $tag],
            $tags->toArray()
        );
    }

    public function testConvertToTagsWithString()
    {
        $tags = convert_to_tags('tag1,tag2,');

        $this->assertEquals(
            [new Tag(['name' => 'tag1']), new Tag(['name' => 'tag2'])],
            $tags->toArray()
        );
    }
}
