<?php
 
use PhpParser\Node\Stmt\While_;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Projetux\Service\TarefaService;
use Projetux\Infra\Debug;
use Projetux\Math\Math;
 
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

$app->get('/teste-debug',function (Request $request, Response $response, array $args){
    $debug = new Debug();
    $response->getBody()->write($debug->debug('teste 00001'));
    return $response;
});



$app->get("/math/soma/{num1}/{num2}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->soma($args['num1'],$args['num2']);
    $response->getBody()->write((string) $resultado);
    return $response;
});

$app->get("/math/menos/{num1}/{num2}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->menos($args['num1'],$args['num2']);
    $response->getBody()->write((string) $resultado);
    return $response;
});

$app->get("/math/produto/{num1}/{num2}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->produto($args['num1'],$args['num2']);
    $response->getBody()->write((string) $resultado);
    return $response;
});

$app->get("/math/divide/{num1}/{num2}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->divide($args['num1'],$args['num2']);
    $response->getBody()->write((string) $resultado);
    return $response;
});


$app->get("/math/quadrado/{num1}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->quadrado($args['num1']);
    $response->getBody()->write((string) $resultado);
    return $response;
});
$app->get("/math/raiz/{num1}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->raiz($args['num1']);
    $response->getBody()->write((string) $resultado);
    return $response;
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



$app->delete('/tarefas/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $tarefa_service = new TarefaService();
    $tarefa_service->deleteTarefa($id);
    return $response->withStatus(202);
});

$app->put('/tarefas/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $dados_para_atualizar = json_decode($request ->getBody()->getContents(),true);
    if(array_key_exists('titulo',$dados_para_atualizar) && empty($dados_para_atualizar['titulo'])){
        $response->getBody()->write(json_encode([
            "mensagem" =>"titulo é obrigatorio"


        ]));
        return $response->withHeader('Content-Type','application/json')->withStatus(400);
    }
    $tarefa_service = new TarefaService();
    $tarefa_service->updateTarefa($id,$dados_para_atualizar);

    return $response->withStatus(201);
});
 
 
 
$app->run();