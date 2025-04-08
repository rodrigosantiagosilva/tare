<?php
 
use PhpParser\Node\Stmt\While_;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use RodrigoSilva14\Tarefas\Service\TarefaService;
 
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
$app->get('/tarefas', function (Request $request, Response $response, array $args) {
    $tarefa_service = new TarefaService();
    $tarefas = $tarefa_service -> getAllTarefas();

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
    $modelo = array_merge(['titulo' =>'','concluido' =>false],$parametros);
    $tarefa_service = new TarefaService();
    $tarefa_service ->createTarefa($parametros);
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
 
 
 
$app->run();