<?php

namespace Altan\YesimTest\Controller;

use Altan\YesimTest\Model\ItemModel;
use Altan\YesimTest\Tools\Db\DatabaseInterface;

/**
 * ItemController
 */
class ItemController extends Controller
{
    /**
     * __construct
     *
     * @param  mixed $db
     * @return void
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->model = new ItemModel($db);
    }
    /**
     * processGetRequest
     *
     * @param  mixed $uri
     * @return void
     */
    protected function processGetRequest(array $uri): void
    {
        if (isset($uri[1]) && (intval($uri[1]) > 0)) {
            $this->data = $this->model->getItem(intval($uri[1]));
        } else {
            $this->data = $this->model->listItems();
        }
    }
    /**
     * processPostRequest
     *
     * @param  mixed $uri
     * @return void
     */
    protected function processPostRequest(array $uri): void
    {
        $request = $this->readRequest();
        if ($this->model->validate($request)) {
            $this->data = ['id' => $this->model->createItem($request)];
        }
    }
    /**
     * processPatchRequest
     *
     * @param  mixed $uri
     * @return void
     */
    protected function processPatchRequest(array $uri): void
    {
        if (isset($uri[1]) && intval($uri[1]) > 0) {
            $request = $this->readRequest();
            $this->model->updateItem(intval($uri[1]), $request);
        }
    }
    /**
     * processDeleteRequest
     *
     * @param  mixed $uri
     * @return void
     */
    protected function processDeleteRequest(array $uri): void
    {
        if (isset($uri[1]) && intval($uri[1]) > 0) {
            $this->model->deleteItem(intval($uri[1]));
        }
    }
}
