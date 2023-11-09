<?php

namespace Altan\YesimTest\View;

/**
 * JsonView
 */
class JsonView extends View
{
    /**
     * write
     *
     * @return void
     */
    public function write(): void
    {
        $this->writeData($this->data);
    }    
    /**
     * writeError
     *
     * @return void
     */
    public function writeError(): void
    {
        $this->writeData($this->data);
    }    
    /**
     * writeData
     *
     * @param  mixed $data
     * @return void
     */
    private function writeData($data): void
    {
        http_response_code($this->status);
        header($this->status);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header(
            "Access-Control-Allow-Headers: Content-Type," .
            "Access-Control-Allow-Headers, Authorization, X-Requested-With"
        );
        echo json_encode($data);
    }
}
