<?php
namespace app\core;
class Request{
    private array $routeparams = [];
    public function getpath(){
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        $request_url = rtrim($path, '/');
        if($position === false){
            return $request_url;
        }
        return substr($request_url, 0, $position);
    }
    public function getmethod(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function setrouteparams($params){
        $this->routeparams = $params;
        return $this;
    }
    public function getrouteparams(){
        return $this->routeparams;
    }
    public function input($params){
        return trim($_POST[$params]);
    }
}