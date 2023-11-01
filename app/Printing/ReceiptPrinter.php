<?php


// app/Printing/ReceiptPrinter.php

namespace App\Printing;

use Mike42\GfxPhp\Image;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\CapabilityProfile;
use App\Events\PrintKitchenReceiptEvent;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ReceiptPrinter
{

}
