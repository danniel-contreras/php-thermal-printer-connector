<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

require_once __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Hello World!');
    return $response;
});

$app->post('/test', function (Request $request, Response $response, array $args) {
    $data = $request->getParsedBody();
    try {
        // Enter the share name for your USB printer here
        $connector = new WindowsPrintConnector("THERMAL-001");
        /* Print a "Hello world" receipt" */
        $printer = new Printer($connector);

        $printer->text("El sotano!\n");
        foreach ($data["products"] as $res) {
            $printer->text($res['name'] . " - " . $res["price"] . "\n");
        }
        $printer->cut();
        /* Close printer */
        $printer->close();
        $res = (object)[
            "ok" => true,
            "message" => "Se imprimio con exito!!"
        ];
        $response->getBody()->write(json_encode($res));
        return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    }
    catch (Exception $e) {
        $res = (object)[
            "ok" => false,
            "message" => "Error al imprimir!!"
        ];
        $response->getBody()->write(json_encode($res));
        return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(500);
    }
});

$app->run();