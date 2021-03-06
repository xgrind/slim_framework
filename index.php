<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as Capsule;

require 'vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$container = $app->getContainer();
$container['db'] = function() {

    $capsule = new Capsule;
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'slim',
        'username'  => 'root',
        'password'  => 'banco1234',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$app->get('/usuarios', function(Request $request, Response $response) {

    $db = $this->get('db');
    // $db->schema()->dropIfExists('usuarios');
    // $db->schema()->create('usuarios', function($table) {

    //     $table->increments('id');
    //     $table->string('nome');
    //     $table->string('email');
    //     $table->timestamps();

    // });

    //inserir
    // $db->table('usuarios')->insert([
    //     'nome' => 'Michael Martins',
    //     'email' => 'michaelfm21@gmail.com'
    // ]);

    //atualizar
    // $db->table('usuarios')
    //             ->where('id', 1)
    //             ->update([
    //                 'nome' => 'Michael'
    //             ]);

    //deletar
    // $db->table('usuarios')
    //             ->where('id', 1)
    //             ->delete();


    //listar
    $usuarios = $db->table('usuarios')->get();

    foreach($usuarios as $usuario) {
        echo $usuario->nome . '<br>';
    }
                
    
});

$app->run();


/* Tipos de respostas
cabeçalho, texto, Json, XML
 */

// $app->get('/header', function(Request $request, Response $response) {

//     $response->write('Esse é um retorno header');
//     return $response->withHeader('allow', 'PUT')
//              ->withAddedHeader('Content-Length', 10) ;
    
// });

// $app->get('/json', function(Request $request, Response $response) {

//     return $response->withJson([
//         "nome" => "Michael Martins",
//         "endereco" => "Teste"
//     ]);
    
// });

// $app->get('/xml', function(Request $request, Response $response) {

//     $xml = file_get_contents('arquivo.xml');
//     $response->write($xml);

//     return $response->withHeader('Content-Type', 'application/xml');
    
// });



/* middleware */
// $app->add(function($request, $response, $next) {
//     $response->write(' Inicio camadas 1 + ');

//     // return $next($request, $response);

//     $reponse = $next($request, $response);
//     $response->write(' + Fim da camada 1 ');

//     return $response;
// });

// $app->add(function($request, $response, $next) {
//     $response->write(' Inicio camadas 2 + ');

//     // return $next($request, $response);

//     $reponse = $next($request, $response);
//     $response->write(' + Fim da camada 2 ');

//     return $response;
// });

// // $app->add(function($request, $response, $next) {
// //     $response->write(' Inicio camadas 2 + ');

// //     return $next($request, $response);
// // });

// $app->get('/usuarios', function(Request $request, Response $response) {
    
//     $response->write('Ação principal usuários');    
    
// });

// $app->get('/postagens', function(Request $request, Response $response) {
    
//     $response->write('Ação principal postagens');    
    
// });




/* Container dependecy injection */
// class Servico {

// }

// $servico = new Servico;

/* Container Pimple */
// $container = $app->getContainer();
// $container['servico'] = function() {
//     return new Servico;
// };

// $app->get('/servico', function(Request $request, Response $response) {

//     $servico = $this->get('servico');
//     var_dump($servico);
    
// });



/* Controllers como serviço */
// $container = $app->getContainer();
// $container['Home'] = function() {
//     return new MyApp\controllers\Home(new MyApp\View);
// };

// $app->get('/usuario', 'Home:index');



/* Padrão PSR7 */
// $app->get('/postagens', function(Request $request, Response $response) {
//     /* Escreve no corpo da resposta utilizando o Psr7 */
//     $response->getBody()->write("Listagem de postagens");

//     return $response;
// });

// $app->post('/usuarios/adiciona', function(Request $request, Response $response) {
    
//     //Recupera post ($_POST)
//     $post = $request->getParsedBody();
//     $nome = $post['nome'];
//     $idade = $post['idade'];

//     return $response->getBody()->write("Sucesso");
// });

// $app->put('/usuarios/atualiza', function(Request $request, Response $response) {
    
//     //Recupera post ($_POST)
//     $post = $request->getParsedBody();
//     $id = $post['id'];
//     $nome = $post['nome'];
//     $idade = $post['idade'];

//     return $response->getBody()->write("Sucesso ao atualizar " . $id);
// });

// $app->delete('/usuarios/remove/{id}', function(Request $request, Response $response) {
    
//     $id = $request->getAttribute('id');

//     /* Deletar do banco de dados */

//     return $response->getBody()->write("Sucesso ao remover " . $id);
// });


/* Tipos de requisição ou Verbos HTTP

    get -> recuperar recursos do servidor (select)
    post -> criar dado no servidor (insert)
    put -> atualizar dados no servidor (update)
    delete -> deletar dados do servidor (delete)

*/




// $app->get('/postagens2', function() {
//     echo "Lista de postagens";
// });

// $app->get('/usuarios[/{id}]', function($request, $response) {
//     $id = $request->getAttribute('id');
//     echo "Lista de usuarios ou ID: " . $id;
// });

// $app->get('/postagens[/{ano}[/{mes}]]', function($request, $response) {
//     $ano = $request->getAttribute('ano');
//     $mes = $request->getAttribute('mes');
//     echo "Lista de postagens Ano: " . $ano . " Mês: " . $mes;
// });

// $app->get('/lista/{itens:.*}', function($request, $response) {
//     $itens = $request->getAttribute('itens');
    
//     // echo $itens;
//     var_dump(explode("/", $itens));
// });

// /* Nomear rotas */
// $app->get('/blog/postagens/{id}', function($request, $response) {
//     echo "Listar postagem para id";
// })->setName("blog");

// $app->get('/meusite', function($request, $response) {
//     $retorno = $this->get("router")->pathFor("blog", ["id" => "10"]);

//     echo $retorno;
// });

// /* Agrupar rotas */
// $app->group('/v1', function() {
//     $this->get('/usuarios', function() {
//         echo "Listar de usuarios";
//     });
    
//     $this->get('/postagens', function($request, $response) {
//         echo "Listar de postagens";
//     });
// });





