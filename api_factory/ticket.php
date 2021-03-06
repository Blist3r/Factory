<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, GET, PUT, DELETE');

header('content-type: application/json; charset=utf-8');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/src/LucidFrame/Console/ConsoleTable.php'; //Nota: si renombraste la carpeta a algo diferente de "vendor" cambia el nombre en esta línea

date_default_timezone_set("America/Bogota");

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use LucidFrame\Console\ConsoleTable.php;

$nombre_impresora = "pos"; 

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

//PARA IMPRIMIR TODO CENTRADO
$printer->setJustification(Printer::JUSTIFY_CENTER);

$logo = EscposImage::load('img/logo.png', false);

$printer->bitImage($logo);
$printer->text('1193429241 - 3'."\n");
$printer->text('Regimen Simplificado - 3'."\n");
$printer->text('Sucursal: '.$_GET['sucursal']['nombre']." \n");
$printer->text('Telefono: 3054026670'." \n");
$printer->setTextSize(2,3);

//CABECERA FACTURA
$printer->text("\n".'Venta: '.$_GET['venta']['id']."\n");
$printer->setTextSize(1,1);

//Se construye una tabla con la informacion de sucursal
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("\n"."Fecha: ".date("d/m/Y H:i:s", strtotime($_GET['venta']['created_at']))." \n\n");

$printer->text($_GET['cliente']['nombre']." ".$_GET['cliente']['apellido']."\n");
$printer->text($_GET['cliente']['telefono'] ?: " ");
$printer->text("\n".$_GET['cliente']['direccion'] ?: " ");
$printer->text("\n");

//Se construye una tabla de la informacion de la factura
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->setTextSize(1,2);
$printer->text("\n".'ENTREGAR'."\n");
$printer->setTextSize(1,1);
$printer->text('Productos'."\n\n");


//SE CONSTRUYE UNA TABLA DE CONSOLA Y SE CONVIERTE A STRING :)
$table = new LucidFrame\Console\ConsoleTable();

// $table->setHeaders(array('Cod.', 'Producto', 'Cant.', 'Valor'));

$totalprecio=0;
$subtotalprecio=0;
$complementostotal=0;
$descuento=0;
$cupon=0;

foreach($_GET['venta']['productos'] as $key => $value) {
    $subtotalprecio += $value['producto']['valor'] * $value['cantidad'];

    $printer->text(new item(substr($value['cantidad'].'x '.$value['producto']['nombre'], 0, 35), '$'.number_format($value['producto']['valor'] * $value['cantidad'])));
    $totalprecio += $value['producto']['valor'] * $value['cantidad'];
}


$table->hideBorder();

//SE IMPRIME
$printer->text($table->getTable()."\n");
$printer->setTextSize(1,1);

$printer->setJustification(Printer::JUSTIFY_RIGHT);

$printer->text("Subtotal: $".number_format($subtotalprecio)."\n");

// if ($_GET['cost_sending']) {
// 	$printer->text('Envio: $'.number_format($_GET['cost_sending'])."\n");
// }
if($_GET['venta']['domicilio'] == 1) {
    $printer->text('Envio: $3.000'."\n");
    $subtotalprecio = $subtotalprecio + 3000;
}

if($_GET['venta']['propina'] == 1) {
    $printer->text('Propina:'.$value['valor_propina']."\n");
    $subtotalprecio = $subtotalprecio + $value['valor_propina'];
}


$printer->text("TOTAL A PAGAR: $".number_format($subtotalprecio)."\n\n");

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Forma de pago: Efectivo"."\n");
// $printer->text("Cambio: $".number_format($_GET['change'])."\n\n");

$printer->setJustification(Printer::JUSTIFY_RIGHT);
// $printer->text("Desarrollado por InterWap"."\n");
// $printer->text($_GET['url'] . "\n");
//ALIMENTAMOS IMPRESORA
$printer->feed();

//CORTAMOS EL PAPEL CUANDO TERMINE
$printer->cut();

//ESTE PULSE ES PARA ABRIR LA CAJA LUEGO DE IMPRIMIR LA FACTURA
$printer->pulse(); 

// dd($printer);
$printer->close();

class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 34;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;

        $sign = ($this -> dollarSign ? '$ ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}

?>