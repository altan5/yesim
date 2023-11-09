<?php

namespace Altan\YesimTest\Tools\Logger;

use PDO;

/**
 * MysqlLogger
 */
class MysqlLogger implements LoggerInterface
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private PDO $database
    ) {
    }    
    /**
     * log
     *
     * @param  mixed $entity
     * @param  mixed $item_id
     * @param  mixed $changes
     * @return void
     */
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
    /**
     * logCreate
     *
     * @param  mixed $entity
     * @param  mixed $item_id
     * @param  mixed $item
     * @return void
     */
    public function logCreate($entity, $item_id, $item)
    {
        $changes = json_encode([
            'action' => 'create',
            'old_item' => null,
            'new_item' => $item
        ]);
        $this->log($entity, $item_id, $changes);
    }    
    /**
     * logUpdate
     *
     * @param  mixed $entity
     * @param  mixed $item_id
     * @param  mixed $old_item
     * @param  mixed $new_item
     * @return void
     */
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
    /**
     * logDelete
     *
     * @param  mixed $entity
     * @param  mixed $item_id
     * @return void
     */
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
