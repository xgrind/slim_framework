<?php

require 'vendor/autoload.php';

$app = new \Slim\App;

$app->get('/postagens', function() {
    echo "Lista de postagens";
});

// $app->get('/usuarios/{id}', function($request, $response) {
//     $id = $request->getAttribute('id')
//     echo "Lista de usuarios";
// });

$app->run();
