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


$app->get("/math/areaquadrado/{num1}/{num2}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->areaquadrado($args['num1'],$args['num2']);
    $response->getBody()->write((string) $resultado);
    return $response;
});

$app->get("/math/areatriangulo/{num1}/{num2}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->areatriangulo($args['num1'],$args['num2']);
    $response->getBody()->write((string) $resultado);
    return $response;
});

$app->post("/math/areatriangulo/{num1}/{num2}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->areatriangulo($args['num1'],$args['num2']);
    $response->getBody()->write((string) $resultado);
    return $response;
});
$app->post("/math/areaquadrado/{num1}/{num2}", function (Request $request, Response $response, array $args){
    $math = new Math();
    $resultado = $math->areaquadrado($args['num1'],$args['num2']);
    $response->getBody()->write((string) $resultado);
    return $response;
});


 
$app->run();