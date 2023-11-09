<?php

namespace Altan\YesimTest\Tools\Logger;

interface LoggerInterface
{    
    /**
     * logCreate
     *
     * @param  mixed $entity
     * @param  mixed $item_id
     * @param  mixed $item
     * @return void
     */
    public function logCreate($entity, $item_id, $item);    
    /**
     * logUpdate
     *
     * @param  mixed $entity
     * @param  mixed $item_id
     * @param  mixed $old_item
     * @param  mixed $new_item
     * @return void
     */
    public function logUpdate($entity, $item_id, $old_item, $new_item);    
    /**
     * logDelete
     *
     * @param  mixed $entity
     * @param  mixed $item_id
     * @return void
     */
    public function logDelete($entity, $item_id);
}
