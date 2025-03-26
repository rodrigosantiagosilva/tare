<?php
 
use PhpParser\Node\Stmt\While_;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
 
require __DIR__ . '/vendor/autoload.php';
 
$app = AppFactory::create();
 
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
    Request $request,
    Throwable $expection,
    bool $diplayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write('{"error": "deu erro"}');
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});
 
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});
$app->get('/tarefas', function (Request $request, Response $response, array $args) {
    $tarefas =[
        ["id" => 1,"titulo" =>"ler a documentação do Slim","concluido"=> false],
        ["id" => 2,"titulo" =>"ler alguma coisa ","concluido"=>false],
        ["id" => 3,"titulo" =>"fazer alguma coisa ","concluido"=>false],
        ["id" => 4,"titulo" =>"ser alguma coisa ","concluido"=>false],
    ];
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type','application/json');
});
$app->post('/tarefas', function (Request $request, Response $response, array $args) {
    $parametros =(array) $request ->getParsedBody();
    if(!array_key_exists('titulo',$parametros) || empty($parametros['titulo'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "titulo obrigatorio"
        ]));
    }
    return $response->withStatus(201);

});

$app->delete('/tarefas/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    return $response->withStatus(204);
});
$app->put('/tarefas/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $dados_para_atualizar = (array) $request->getParsedBody();
    var_dump($dados_para_atualizar);
    if(array_key_exists('titulo',$dados_para_atualizar) && empty($dados_para_atualizar['titulo'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "titulo é obrigatorio"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    return $response->withStatus(201);




});
 
$app->run();