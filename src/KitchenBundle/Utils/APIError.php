<?php

namespace KitchenBundle\Utils;


/**
 * Description of APIResponse
 */
class APIError {

    public function getError($key, $value) {
        switch ($key) {
            case 'time':
                return new APITime($value);
                break;
            case 'user':
                return new APIServiceSapboCode($value);
                break;
            case 'chef':
                return new APIPublicClientSapboCode($value);
                break;
            case 'clean':
                return new APIIncomeLevel($value);
                break;
            case 'status':
                return new APIStatus($value);
                break;
            case 'ceco':
                return new APICeco($value);
                break;
            case 'center':
                return new APICenter($value);
                break;
            case 'model':
                return new APIModel($value);
                break;
            case 'type':
                return new APIType($value);
                break;
            case 'publicClient':
                return new APIPublicClient($value);
                break;
            case 'privateRate':
                return new APIPrivateRate($value);
                break;
            case 'publicRate':
                return new APIPublicRate($value);
                break;
            case 'name':
                return new APIName($value);
                break;
        }
    }

}

class APIName {

    public $name;

    public function __construct($error) {
        $this->name = $error;
    }

}
class APIIncomeLevel {

    public $income_level;

    public function __construct($error) {
        $this->income_level = $error;
    }

}
class APIStatus {

    public $type;

    public function __construct($error) {
        $this->type = $error;
    }

}
class APIType {

    public $type;

    public function __construct($error) {
        $this->type = $error;
    }

}
class APIServiceSapboCode {

    public $service_sapbo_code;

    public function __construct($error) {
        $this->service_sapbo_code = $error;
    }

}
class APIPublicClientSapboCode {

    public $public_client_sapbo_code;

    public function __construct($error) {
        $this->public_client_sapbo_code = $error;
    }

}
class APIPublicClient {

    public $public_client_code;

    public function __construct($error) {
        $this->public_client_code = $error;
    }

}
class APIModel {

    public $model;

    public function __construct($error) {
        $this->model = $error;
    }

}
class APICeco {

    public $ceco;

    public function __construct($error) {
        $this->ceco = $error;
    }

}
class APICenter {

    public $center_ceco;

    public function __construct($error) {
        $this->center_ceco = $error;
    }

}
class APIPrivateRate {

    public $private_price;

    public function __construct($error) {
        $this->private_price = $error;
    }

}
class APIPublicRate {

    public $public_price;

    public function __construct($error) {
        $this->public_price = $error;
    }

}
