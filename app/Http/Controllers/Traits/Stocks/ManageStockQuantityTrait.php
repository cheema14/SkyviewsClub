<?php

namespace App\Http\Controllers\Traits\Stocks;

use App\Models\GrItemDetail;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait ManageStockQuantityTrait
{
    public function manage_stock_item_quantity($request_object){
        // dd($request_object['items']);
        
        foreach($request_object['items'] as $key=>$item){
            $gr_item_detail = GrItemDetail::where('item_id',$item['item_id'])->first();
            
            if($gr_item_detail && $gr_item_detail->quantity > 0){
               $gr_item_detail->quantity = $gr_item_detail->quantity - $item['issued_qty'];
               $gr_item_detail->save(); 
            }

            return back()->with('out_of_stock','Item is out of stock');
        }
    }    
}
