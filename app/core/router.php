<?php
namespace app\core;
class router extends Controller{
    public Request $request;
    public Response $response;
  protected array $routes = [];
  public function __construct(Request $request,Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }
  public function get($path, $callback){
    $newpath = rtrim($path,'/');

    $this->routes['get'][$newpath] = $callback;
  }
  public function post($path, $callback){
    $newpath = rtrim($path,'/');
    $this->routes['post'][$newpath] = $callback;
  }
  public function getcallback(){
    $path = $this->request->getpath();
    $method = $this->request->getmethod();
    $path = trim($path,'/');
    $routes = $this->routes[$method] ?? [];
    $routeparams = false;
    foreach($routes as $route => $callback){
      $route = trim($route, '/');
      $routenames = [];
      if(!$route){
        continue;
      }
      if(preg_match_all('/\{(\w+)(:[^}]+)?}/',$route, $matches)){
        $routenames = $matches[1];
      }
      $routeregex = "$". preg_replace_callback('/\{(\w+)(:[^}]+)?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)',$route) . "$";
      //       echo '<pre>';
      // var_dump($routeregex);
      // echo '</pre>';
     // test route against the current route regex
     if(preg_match_all($routeregex,$path,$valuematches)){
      // echo '<pre>';
      // var_dump($valuematches);
      // echo '</pre>';
      $values = [];
      for($i =1; $i < count($valuematches); $i++){
        $values[] = $valuematches[$i][0];
      }
      $routeparams = array_combine($routenames,$values);
      $this->request->setrouteparams($routeparams);
      return $callback;
     }
    }
    return false;
  }
  public function resolve(){
    $path = $this->request->getpath();
    $method = $this->request->getmethod();
    $callback = $this->routes[$method][$path] ?? false;
    if($callback == false){
      $callback = $this->getcallback();
      if($callback === false){
        $this->response->setstatuscode(404);
        return $this->view("404");
      }
    }
    if(is_string($callback)){
      $callback[0] = new $callback[0]();
    }
    if(is_array($callback)){
        $callback[0] = new $callback[0]();
    }
    return call_user_func($callback,$this->request,$this->response); 
  }
  // public function view($view){
  //   $layoutcontent = $this->layoutcontent();
  //   include_once App::$ROOT_DIR."/views/$view.php";
  // }
  // protected function layoutcontent(){
  //   include_once App::$ROOT_DIR."/views/layouts/weblayouts.php";
  // }
}