<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use App\Printing\ReceiptPrinter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

class KitchenReceiptController extends Controller
{
    public function index(Order $order){

        $data = $order->load('items','tableTop');

        // $order->fill(['status' => Order::STATUS_SELECT['Active']]);
        // $order->update();

        return view('admin.bills.kitchen_receipt',['data'=>$data]);
    }
}
