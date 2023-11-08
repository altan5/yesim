<?php

namespace Altan\YesimTest\Tools\Logger;

use PDO;

class MysqlLogger implements LoggerInterface
{
    public function __construct(
        private PDO $database
    ) {
    }
    private function log($entity, $item_id, $changes)
    {
        $query = "INSERT INTO `logger_table` (`entity`, `item_id`, `changes`) " .
            " VALUES (:entity, :item_id, :changes)";
        $stmt = $this->database->prepare($query);
        $stmt->execute([
            "entity" => $entity,
            "item_id" => $item_id,
            "changes" => $changes
        ]);
    }
    public function logCreate($entity, $item_id, $item)
    {
        $changes = json_encode([
            'action' => 'create',
            'old_item' => null,
            'new_item' => $item
        ]);
        $this->log($entity, $item_id, $changes);
    }
    public function logUpdate($entity, $item_id, $old_item, $new_item)
    {
        $new_item = array_replace($old_item, $new_item);
        $changes = json_encode([
            'action' => 'update',
            'old_item' => $old_item,
            'new_item' => $new_item
        ]);
        $this->log($entity, $item_id, $changes);
    }
    public function logDelete($entity, $item_id)
    {
        $changes = json_encode([
            'action' => 'delete',
            'old_item' => null,
            'new_item' => null
        ]);
        $this->log($entity, $item_id, $changes);
    }
}
