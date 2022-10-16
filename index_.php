<?php
/* Call this file 'hello-world.php' */
require __DIR__ . '/vendor/autoload.php';
use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use UsePrint\PrinterModel;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
header('Access-Control-Allow-Origin:*');    
header('Access-Control-Request-Method: GET');
header('Access-Control-Request-Method: POST');
// try {
//     // Enter the share name for your USB printer here
//     $connector = new WindowsPrintConnector("THERMAL-001");
//     /* Print a "Hello world" receipt" */
//     $printer = new Printer($connector);

//     $printer -> text("Hola Fer!\n");
//     $printer -> text("Te amooooooo!\n");
//     $printer -> text("Nos casamos?\n");
//     $printer -> cut();

//     /* Close printer */
//     $printer -> close();
// } catch(Exception $e) {
//     echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
// }

if(1>0) {
    $app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);
    $c = $app->getContainer();
    $c['notAllowedHandler'] = function ($c) {
        return function ($request, $response, $methods) use ($c) {
            return $c['response']
                ->withStatus(405)
                ->withHeader('Allow', implode(', ', $methods))
                ->withHeader('Content-type', 'text/html')
                ->write('Method must be one of: ' . implode(', ', $methods));
        };
    };
  } else {
    $app = new \Slim\App;
  }

$app->post('/api/login', function ($request, $response){
    $obj = (object)[
        "ok"=>true
    ];
    $response = $response->withJson($obj, 200);
// other code
return $response;
});

$app->run();