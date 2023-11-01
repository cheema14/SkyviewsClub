<?php

namespace App\Listeners;

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PrintUpdatedKitchenReceiptListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $menuConfig = config('printers');

        $printerPort = 9100;

        try {

            $itemsArray = $event->content;

            // $totalItems = count($itemsArray);
            foreach ($itemsArray as $key => $item) {

                $menuId = $item['menu_id'];

                if (isset($menuConfig["menu$menuId"])) {

                    $printerIp = $menuConfig["menu$menuId"];
                    $printerPort = 9100; // Change the port if needed

                    // $printerShareName = 'PAF Printer';
                    // $connector = new WindowsPrintConnector($printerShareName);

                    $connector = new NetworkPrintConnector($printerIp, $printerPort);
                    $printer = new Printer($connector);

                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text('Time:');
                    $printer->text(date('d-m-Y H:i:s'));
                    $printer->text("\n");

                    $printer->setJustification(Printer::JUSTIFY_RIGHT);
                    $printer->text('SR No:');
                    $printer->text($event->content['data']['id']);
                    $printer->text("\n");

                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->setEmphasis(true);

                    // // Print the header
                    $printer->text('PAF Sky Views');
                    $printer->text("\n\n");
                    $printer->text("Kitchen Receipt\n");
                    $printer->text("\n");
                    $printer->text($event->content['data']->tableTop->code);

                    $printer->text("\n\n");

                    // Print the header

                    $printer->text("--------------------------------\n");
                    $printer->text("| Item Name      | Qty | Price |\n");
                    $printer->text("--------------------------------\n\n");

                    $printer->text('| '.str_pad($item['title'], 15).' | '.str_pad($item['quantity'], 3).' | '.number_format($item['price'], 2)." |\n");
                    $printer->text("\n\n");

                    // Print the total
                    $printer->text("--------------------------------\n");
                    $printer->text("\n\n");

                    $printer->cut();
                    $printer->close();

                } else {
                    // Handle cases where there is no IP address for the menu_id
                    // You can log an error or take appropriate action

                }

            }
        } catch (\Exception $e) {
            // Handle the exception here
            echo 'Exception: '.$e->getMessage();
        }
    }
}
