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
$app->get('/usuarios/{id}', function (Request $request, Response $response, array $args) {
    $tarefas =[
        ["id" => 1,"nome" =>"Usuario 1","admin"=>false,"senha" =>"1534"],
        ["id" => 2,"nome" =>"Usuario 2","admin"=>false,"senha" =>"1334"],
        ["id" => 3,"nome" =>"Usuario 3","admin"=>true,"senha" =>"1214"],
        ["id" => 4,"nome" =>"Usuario 4","admin"=>false,"senha" =>"1224"],
    ];
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type','application/json');
});
$app->post('/usuarios', function (Request $request, Response $response, array $args) {
    $parametros =(array) $request ->getParsedBody();
    if(!array_key_exists('nome',$parametros) || empty($parametros['nome'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "nome obrigatorio"
        ]));
    }
    return $response->withStatus(201);

});

$app->delete('/usuarios/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    return $response->withStatus(204);
});
$app->put('/usuarios/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $dados_para_atualizar = (array) $request->getParsedBody();
    var_dump($dados_para_atualizar);
    if(array_key_exists('nome',$dados_para_atualizar) && empty($dados_para_atualizar['nome'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "nome é obrigatorio"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    return $response->withStatus(201);
});
 
$app->put('/usuarios/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $dados_para_atualizar = (array) $request->getParsedBody();
    var_dump($dados_para_atualizar);
    if(array_key_exists('senha',$dados_para_atualizar) && empty($dados_para_atualizar['senha'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "senha é obrigatorio"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    return $response->withStatus(201);
});
 
$app->run();