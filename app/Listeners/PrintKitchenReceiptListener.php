<?php

namespace App\Listeners;

// namespace App\Printing;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

class PrintKitchenReceiptListener implements ShouldQueue
{
    use InteractsWithQueue;

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

            $itemsArray = $event->content->items;

            foreach ($itemsArray as $key => $item) {
                $menuId = $item->pivot->menu_id;

                if (isset($menuConfig["menu$menuId"])) {
                    $printerIp = $menuConfig["menu$menuId"];
                    $printerPort = 9100; // Change the port if needed

                    $connector = new NetworkPrintConnector($printerIp, $printerPort);
                    $printer = new Printer($connector);

                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text('Time:');
                    $printer->text(date('d-m-Y H:i:s'));
                    $printer->text("\n");

                    $printer->setJustification(Printer::JUSTIFY_RIGHT);
                    $printer->text('SR No:');
                    $printer->text($event->content->id);
                    $printer->text("\n");

                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->setEmphasis(true);

                    // // Print the header
                    $printer->text('PAF Sky Views');
                    $printer->text("\n\n");
                    $printer->text("Kitchen Receipt\n");
                    $printer->text("\n");
                    $printer->text($event->content->tableTop?->code);

                    $printer->text("\n\n");

                    // Print the header

                    $printer->text("--------------------------------\n");
                    $printer->text("| Item Name      | Qty | Price |\n");
                    $printer->text("--------------------------------\n\n");

                    $printer->text('| '.str_pad($item['title'], 15).' | '.str_pad($item['pivot']['quantity'], 3).' | '.number_format($item['price'], 2)." |\n");
                    $printer->text("\n\n");

                    // Print the total
                    $printer->text("--------------------------------\n");
                    $printer->text("\n\n");

                    // Cut paper and close the printers
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
