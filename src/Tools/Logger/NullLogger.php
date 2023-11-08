<?php

namespace Altan\YesimTest\Tools\Logger;

class NullLogger implements LoggerInterface
{
    public function __construct()
    {
    }
    public function logCreate($entity, $item_id, $item)
    {
    }
    public function logUpdate($entity, $item_id, $old_item, $new_item)
    {
    }
    public function logDelete($entity, $item_id)
    {
    }
}
