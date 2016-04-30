<?php

namespace KitchenBundle\Utils;

/**
 * Description of APIResponse
 */
class APIResponse {

    private $status;
    private $data;
    private $error;
    
    public function __construct($status = "", $data = "", $error = "") {
        $this->status = $status;
        $this->data = $data;
        $this->error = $error;
    }
    
    public function getResponse() {
        $res = array(
            'status'    =>  $this->status,
            'data'      =>  $this->data,
            'error'     =>  $this->error,
        );
        
        return $res;
    }

    function getStatus() {
        return $this->status;
    }

    function getData() {
        return $this->data;
    }

    function getError() {
        return $this->error;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setError($error) {
        $this->error = $error;
    }
}
