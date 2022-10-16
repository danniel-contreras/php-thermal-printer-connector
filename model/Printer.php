<?php
namespace UsePrint {
    use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
    use Mike42\Escpos\Printer;

    class PrinterModel
    {
        public static function NewPrinter($printer, $data)
        {
            try {
                // Enter the share name for your USB printer here
                $connector = new WindowsPrintConnector($printer);
                /* Print a "Hello world" receipt" */
                $printer = new Printer($connector);

                $printer->text("Hola Mundo!\n");
                foreach ($data as $res) {
                    $printer->text("$res->product - $res->quantity - $res->price\n");
                }
                $printer->cut();
                /* Close printer */
                $printer->close();
                $res = (object)[
                    "ok" => true,
                    "message" => "Se imprimio con exito!!"
                ];
                return $res;
            }
            catch (Exception $e) {
                $res = (object)[
                    "ok" => false,
                    "message" => "Error al imprimir",
                    "cause" => $e
                ];
                return $res;
            }
        }
    }
}

?>
