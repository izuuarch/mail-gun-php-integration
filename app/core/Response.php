<?php
namespace app\core;
class Response{
    public function setstatuscode(int $code){
        http_response_code($code);
    }
}