<?php

namespace Altan\YesimTest;

use Altan\YesimTest\Controller\Controller;
use Altan\YesimTest\Controller\ItemController;
use Altan\YesimTest\Tools\Auth\AuthInterface;
use Altan\YesimTest\Tools\Auth\BearerAuth;
use Altan\YesimTest\Tools\Db\DatabaseInterface;
use Altan\YesimTest\Tools\Db\MysqlDb;
use Altan\YesimTest\View\JsonView;
use Altan\YesimTest\View\View;

class ApiApp
{
    private DatabaseInterface $db;
    public function initDatabase(string $dsn, string $username = "", string $password = "", bool $log_changes = false)
    {
        $this->db = new MysqlDb($dsn, $username, $password, $log_changes);
    }

    public function getAuth(): AuthInterface
    {
        return new BearerAuth();
    }

    public function getController($entity): Controller
    {
        switch ($entity) {
            case "item":
                return new ItemController($this->db);
            default:
                throw new \Exception("No controller for entity '" . $entity . "'");
        }
    }

    public function getView(string $status, array $data): View
    {
        return new JsonView($status, $data);
    }
}
