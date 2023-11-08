<?php

namespace Altan\YesimTest\Tools\Logger;

interface LoggerInterface
{
    public function logCreate($entity, $item_id, $item);
    public function logUpdate($entity, $item_id, $old_item, $new_item);
    public function logDelete($entity, $item_id);
}
