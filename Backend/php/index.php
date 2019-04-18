<?php

require_once './classes/Request.class.php';
require_once './classes/Router.class.php';

$request = new Request();
$router = new Router($request);

// echo "<pre>";
var_dump($request);
// echo "<pre>";

$router->get('/', function () {
    return <<<HTML
  <h1>Hello world</h1>
HTML;
});


$router->get('/profile', function ($request) {
    return <<<HTML
  <h1>Profile</h1>
HTML;
});

$router->post('/data', function ($request) {

    return json_encode($request->getBody());
});
