<?php

require "../app/init.php";

use app\controllers\Contactcontroller;
use app\core\App;
$app = new App();

$app->router->get('/', function(){
 echo "hello there";
});
$app->router->get('/contact', [Contactcontroller::class,'index']);
$app->router->post('/send', [Contactcontroller::class,'send']);
$app->run();

