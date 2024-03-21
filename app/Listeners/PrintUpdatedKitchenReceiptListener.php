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
        $sittingName = config('printers');

        $printerPort = 9100;
        $printer_name = 'PAF Printer';

        try {

            $itemsArray = $event->content;

            // $totalItems = count($itemsArray);
            foreach ($itemsArray as $key => $item) {

                $menuId = $key;

                $menuNumber = preg_replace('/[^0-9]/', '', $key);

                $printerIp = $menuConfig["$menuId"];
                $printerPort = 9100; // Change the port if needed

                // $connector = new WindowsPrintConnector($printer_name);
                // $printer = new Printer($connector);

                $connector = new NetworkPrintConnector($printerIp, $printerPort);
                $printer = new Printer($connector);

                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text('Time:');
                $printer->text(date('d-m-Y H:i:s'));
                $printer->text("\n");

                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text('SR No:');
                $printer->text($event->content['orderDetails']);
                $printer->text("\n");

                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setEmphasis(true);

                // Print the header
                $printer->text('PAF Sky Views');
                $printer->text("\n\n");
                $printer->text("Kitchen Receipt\n");
                $printer->text("\n");
                $printer->text($event->content['tableTop']->code);
                $printer->text("\n");
                $printer->text($sittingName['menu_'.$menuNumber]);

                $printer->text("\n\n");

                // Print the header

                $printer->text("--------------------------------\n");
                $printer->text("| Item Name      | Qty | Price |\n");
                $printer->text("--------------------------------\n\n");

                foreach ($item as $items) {
                    $printer->text($items['title'].'    '.$items['quantity']."\n");
                    $printer->text("\n");

                } // foreach for each menu id

                // Print the total
                $printer->text("--------------------------------\n");
                $printer->text("\n\n");

                $printer->cut();
                $printer->close();

            }
        } catch (\Exception $e) {
            // Handle the exception here
            echo 'Exception: '.$e->getMessage();
        }
    }
}
