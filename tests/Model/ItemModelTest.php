<?php

namespace Altan\YesimTest\Model;

use Altan\YesimTest\Tools\Db\MysqlDb;
use PHPUnit\Framework\TestCase;

class ItemModelTest extends TestCase
{
    private ItemModel $item_model;
    private array $item_ids;
    private array $items = [
        0 => [
            'name' => 'Kos',
            'phone' => '+380631234567',
            'key' => 'some_secret_key',
        ],
        1 => [
            'name' => 'Kos2',
            'phone' => '+380637654321',
            'key' => 'some_secret_key2',
        ],
        2 => [
            'name' => 'Kos3',
            'phone' => '+380635554321',
            'key' => 'some_secret_key3',
        ],
        3 => [
            'name' => 'Kos4',
            'phone' => '+380637774321',
            'key' => 'some_secret_key4',
        ],
        4 => [
            'name' => 'Kos5',
            'phone' => '+380636664321',
            'key' => 'some_secret_key5',
        ]
    ];
    protected function setUp(): void
    {
        $this->item_model = new ItemModel(new MysqlDb(
            $GLOBALS['PDO_DSN'],
            $GLOBALS['PDO_USERNAME'],
            $GLOBALS['PDO_PASSWORD']
        ));
        $this->item_ids[0] = $this->item_model->createItem($this->items[0]);
        $this->item_ids[1] = $this->item_model->createItem($this->items[1]);
    }

    public function testListItems()
    {
        $this->assertTrue(count($this->item_model->listItems()) > 1);
    }

    public function testCreateItem()
    {
        $item_id = $this->item_model->createItem($this->items[2]);
        $this->assertTrue($item_id > 1);
        $this->item_ids[] = $item_id;
    }

    public function testDeleteItem()
    {
        $item_id = $this->item_model->createItem($this->items[3]);
        $this->item_model->deleteItem($item_id);
        $this->assertNull($this->item_model->getItem($item_id));
    }

    public function testUpdateItem()
    {
        $item_id = $this->item_model->createItem($this->items[4]);
        $this->item_ids[] = $item_id;
        $this->item_model->updateItem($item_id, [
            'name' => 'New name',
            'phone' => '456123',
            'key' => 'new_key',
        ]);
        $item = $this->item_model->getItem($item_id);
        $this->assertEquals("New name", $item["name"]);
        $this->assertEquals("456123", $item["phone"]);
        $this->assertEquals("new_key", $item["key"]);
    }

    public function testGetItem()
    {
        $item = $this->item_model->getItem($this->item_ids[0]);
        $this->assertIsArray($item);
        $this->assertEquals($this->items[0]["name"], $item["name"]);
        $this->assertEquals($this->items[0]["phone"], $item["phone"]);
        $this->assertEquals($this->items[0]["key"], $item["key"]);
    }

    public function testValidate()
    {
        $this->assertFalse($this->item_model->validate([]));
        $this->assertFalse($this->item_model->validate([
            'name' => '',
            'phone' => '',
            'key' => '',
        ]));
        $this->assertTrue($this->item_model->validate([
            'name' => 'Kos',
            'phone' => '+380631234567',
            'key' => 'some_secret_key',
        ]));
    }

    protected function tearDown(): void
    {
        foreach ($this->item_ids as $item_id) {
            $this->item_model->deleteItem($item_id);
        }
    }
}
