<?php
namespace app\core;

Class App
{
  public router $router;
  public Request $request;
  public Response $response;
  // public Middleware $middleware;
  public static App $app;
    public function __construct()
    {
      self::$app = $this;
      $this->request = new Request();
      $this->response = new Response();
      $this->router = new router($this->request,$this->response);
      // $this->middleware = new Middleware();
    }

    public function run(){
       echo $this->router->resolve();
    }
}