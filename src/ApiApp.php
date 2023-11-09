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

/**
 * ApiApp
 */
class ApiApp
{
    private DatabaseInterface $db;    
    /**
     * initDatabase
     *
     * @param  mixed $dsn
     * @param  mixed $username
     * @param  mixed $password
     * @param  mixed $log_changes
     * @return void
     */
    public function initDatabase(string $dsn, string $username = "", string $password = "", bool $log_changes = false)
    {
        $this->db = new MysqlDb($dsn, $username, $password, $log_changes);
    }
    
    /**
     * getAuth
     *
     * @return AuthInterface
     */
    public function getAuth(): AuthInterface
    {
        return new BearerAuth();
    }
    
    /**
     * getController
     *
     * @param  mixed $entity
     * @return Controller
     */
    public function getController($entity): Controller
    {
        switch ($entity) {
            case "item":
                return new ItemController($this->db);
            default:
                throw new \Exception("No controller for entity '" . $entity . "'");
        }
    }
    
    /**
     * getView
     *
     * @param  mixed $status
     * @param  mixed $data
     * @return View
     */
    public function getView(string $status, array $data): View
    {
        return new JsonView($status, $data);
    }
}
