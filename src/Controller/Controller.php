<?php

namespace Altan\YesimTest\Controller;

use Altan\YesimTest\Model\Model;

/**
 * Controller
 */
abstract class Controller
{
    protected string $status = "200";
    protected array $data = [];
    protected Model $model;
    /**
     * getStatus
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
    /**
     * getData
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
    /**
     * readRequest
     *
     * @return array
     */
    protected function readRequest(): array
    {
        return (array) json_decode(file_get_contents('php://input'), true);
    }
    /**
     * execute
     *
     * @param  mixed $uri
     * @param  mixed $request_method
     * @return void
     */
    public function execute(array $uri, string $request_method): void
    {
        switch ($request_method) {
            case "GET":
                $this->processGetRequest($uri);
                break;
            case "POST":
                $this->processPostRequest($uri);
                break;
            case "PATCH":
                $this->processPatchRequest($uri);
                break;
            case "DELETE":
                $this->processDeleteRequest($uri);
                break;
            default:
                throw new \Exception("Request method '" . $request_method . "' not supported");
        }
    }
    /**
     * processGetRequest
     *
     * @param  mixed $uri
     * @return void
     */
    abstract protected function processGetRequest(array $uri): void;
    /**
     * processPostRequest
     *
     * @param  mixed $uri
     * @return void
     */
    abstract protected function processPostRequest(array $uri): void;
    /**
     * processPatchRequest
     *
     * @param  mixed $uri
     * @return void
     */
    abstract protected function processPatchRequest(array $uri): void;
    /**
     * processDeleteRequest
     *
     * @param  mixed $uri
     * @return void
     */
    abstract protected function processDeleteRequest(array $uri): void;
}
