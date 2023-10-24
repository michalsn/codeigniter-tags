<?php

namespace Tests;

use Michalsn\CodeIgniterTags\Models\TagModel;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class TagModelTest extends TestCase
{
    private TagModel $tagModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tagModel = model(TagModel::class);

        $this->tagModel->createTags(convert_to_tags('Portugal,Italy'), 1, 'countries');
        $this->tagModel->createTags(convert_to_tags('Carrot,Potato'), 1, 'foods');
    }

    public function testSearchEmpty()
    {
        $result = $this->tagModel->search('qwerty');

        $this->assertCount(0, $result);
    }

    public function testSearch()
    {
        $result = $this->tagModel->search('po');

        $this->assertCount(2, $result);
    }

    public function testSearchWithType()
    {
        $result = $this->tagModel->search('po', 'countries');

        $this->assertCount(1, $result);
    }

    public function testSearchWithPagination()
    {
        $result = $this->tagModel->search('po', null, 1);

        $this->assertCount(1, $result);
        $this->assertSame('Portugal', $result[0]->name);

        $result = $this->tagModel->search('po', null, 1, 1);

        $this->assertCount(1, $result);
        $this->assertSame('Potato', $result[0]->name);

        $result = $this->tagModel->search('po', null, 1, 2);

        $this->assertCount(0, $result);
    }

    public function testFindByTypes()
    {
        $result = $this->tagModel->findByTypes(['countries']);

        $this->assertCount(2, $result);
        $this->assertSame('Portugal', $result[0]->name);
        $this->assertSame('Italy', $result[1]->name);
    }

    public function testFindByTypesMany()
    {
        $result = $this->tagModel->findByTypes(['countries', 'foods']);

        $this->assertCount(4, $result);
        $this->assertSame('Portugal', $result[0]->name);
        $this->assertSame('Italy', $result[1]->name);
        $this->assertSame('Carrot', $result[2]->name);
        $this->assertSame('Potato', $result[3]->name);
    }

    public function testFindByTypesNotExist()
    {
        $result = $this->tagModel->findByTypes(['not-exist']);

        $this->assertCount(0, $result);
    }

    public function testFindByTypesEmpty()
    {
        $result = $this->tagModel->findByTypes([]);

        $this->assertCount(0, $result);
    }
}
