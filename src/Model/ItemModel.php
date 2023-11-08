<?php

namespace Altan\YesimTest\Model;

use Altan\YesimTest\Tools\Db\DatabaseInterface;

/**
 * ItemModel
 */
class ItemModel extends Model
{
    /**
     * __construct
     *
     * @param  mixed $db
     * @return void
     */
    public function __construct(DatabaseInterface $db)
    {
        parent::__construct($db);
        $this->entity = "item";
    }
    /**
     * validate
     *
     * @param  mixed $item
     * @return bool
     */
    public function validate(array $item): bool
    {
        if (count($item) == 0) {
            return false;
        }
        if (isset($item["name"])) {
            if (!$this->validateLenght($item["name"], 1, 255)) {
                return false;
            }
        }
        if (isset($item["phone"])) {
            if (!$this->validateLenght($item["phone"], 1, 15)) {
                return false;
            }
        }
        if (isset($item["key"])) {
            if (!$this->validateLenght($item["key"], 1, 25)) {
                return false;
            }
        }
        return true;
    }
    /**
     * listItems
     *
     * @return array
     */
    public function listItems(): array
    {
        $res = $this->db->getItems($this->entity, ["id"]);
        return $res;
    }
    /**
     * getItem
     *
     * @param  mixed $itemId
     * @return array
     */
    public function getItem(int $itemId): ?array
    {
        $res = $this->db->getItem($this->entity, $itemId);
        return $res;
    }
    /**
     * createItem
     *
     * @param  mixed $item
     * @return int
     */
    public function createItem(array $item): int
    {
        return $this->db->createItem($this->entity, $item);
    }
    /**
     * deleteItem
     *
     * @param  mixed $itemId
     * @return void
     */
    public function deleteItem(int $itemId): void
    {
        $this->db->deleteItem($this->entity, $itemId);
    }
    /**
     * updateItem
     *
     * @param  mixed $itemId
     * @param  mixed $item
     * @return void
     */
    public function updateItem(int $itemId, array $item): void
    {
        $this->db->updateItem($this->entity, $itemId, $item);
    }

    private function validateLenght($s, $min, $max): bool
    {
        if ((strlen($s) > $max) || (strlen($s) < $min)) {
            return false;
        }
        return true;
    }
}
