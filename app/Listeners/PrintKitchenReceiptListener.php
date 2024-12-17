<?php

namespace App\Listeners;

// namespace App\Printing;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
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
        $sittingName = config('printers');
        $printer_name = 'PAF Printer';
        try {

            foreach ($event->content as $key => $value) {
                
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

                // // Print the header
                $printer->text('PAF Sky Views');
                $printer->text("\n\n");
                $printer->text("Kitchen Receipt\n");
                $printer->text("\n");
                $printer->text($event->content['tableTop']?->code);
                $printer->text("\n");
                $printer->text($sittingName['menu_'.$menuNumber]);

                $printer->text("\n\n");

                // Print the header

                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("--------------------------------\n");
                $printer->text("| Item Name |   Qty |\n");
                $printer->text("--------------------------------\n\n");

                
                
                foreach ($event->content['allItems'] as $item) {

                    $printer->text(str_pad($item->title, 15).'    '.str_pad($item->pivot->quantity, 3)."\n");
                    $printer->text("\n");

                } // foreach for each menu id
                
                // Print the total
                $printer->text("--------------------------------\n");
                $printer->text("\n\n");

                // Cut and close printer after every menu id printing
                $printer->cut();
                $printer->close();

            } // foreach for iterating arrays of menuIds

        } catch (\Exception $e) {
            
            // echo 'Exception: '.$e->getMessage();
            // dd($e);
        }

    }
}
