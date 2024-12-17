<!DOCTYPE html>
<!-- saved from url=(0042)http://127.0.0.1:8000/patient/visit-report -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kitchen Receipt</title>
    <link href="{{ asset('css/kitchen_receipt.css') }}" rel="stylesheet" />
</head>

<body>
   
    <div id="receiptDiv" class="">

        <div class="modal-dialog " style="">
            <div class="modal-content">

                <div class="row borderframe scaled">

                    <table style="vertical-align: top;">
                        <tbody>
                            <tr>
                                <td colspan="4" style="text-align: center !important;">
                                    <img alt="logo" src="{{ asset('img/'.tenant()->id.'/golf-logo.png') }}" width="80">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="center_text ">
                                    <h3>{{ tenant()->name }}</h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="center_text ">
                                    <h4>{{$data->tableTop?->code }}</h4>
                                </td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="3" class="left_text">
                                    <label style="text-decoration: underline;"
                                        class="control-label text_size hospital_name_class">
                                        {{ date('d-m-Y H:i:s')}}</label>
                                </td>
                                <td style="text-align: left !important;vertical-align: baseline;padding-top: 13px;">
                                    <label style="text-decoration: underline;"
                                        class="control-label "><strong>New</strong></label>
                                </td>
                            </tr>


                            <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Table</strong></label> <span>{{ $data->tableTop?->code }}</span>
                                </td>
                                <td colspan="2"> <label class="control-label text_size">
                                        <strong>Persons: {{ $data->no_of_guests }}</strong></label>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <label class="control-label text_size">
                                        <strong>QOT</strong></label>
                                    <sapn>{{ $data->status }}</sapn>
                                </td>
                                <td colspan="2"> <label class="control-label text_size">
                                        <strong>QOT Sr: </strong></label>
                                    <sapn>{{ $data->id }}</sapn>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td colspan="4" class="left_text"> <label class="control-label text_size">
                                        <strong>Remarks</strong></label></td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="4" style="border-top: 2px dotted;"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <tbody>
                            <tr class="left_text">
                                <td class="left_text" style="width: 6%;">
                                    <label class="control-label text_size">
                                        <strong>SR</strong></label>
                                </td>
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Item Name</strong></label>
                                </td>
                                <td class="right_text" style="width: 10%;">
                                    <label class="control-label text_size">
                                        <strong>QTY</strong></label>
                                </td>
                            </tr>
{{-- 
    new_added_item ->yes
    new_quantity > 0 
    Quantity update

     new_added_item -> yes
     new_quantity 0 <0
        Update order


      new_added_item -> no
      new_quantity --  0 
       New Order
    
    --}}
                            
                            @foreach ($data->items as $value)
                            
                                <tr class="center_text">
                                    <td class="left_text">
                                        <label class="control-label text_size">
                                            <strong>{{ $loop->iteration }}</strong></label>
                                    </td>
                                    
                                    <td class="left_text">
                                        <label class="control-label text_size">
                                            
                                            {{-- First time kitchen receipt print --}}
                                            @if ($value->pivot->new_added_item == 'no' && $value->pivot->new_quantity == 0)
                                                <strong>{{ $value->title }}</strong></label>

                                            {{-- Update but new item added in existing order --}}
                                            @elseif($value->pivot->new_added_item == 'yes' && $value->pivot->new_quantity == 0) 
                                                <strong>{{ $value->title }} (New Item)</strong></label>
                                                
                                            {{-- Update but existing item`s quantity is changed --}}
                                            @elseif($value->pivot->new_added_item == 'no' && $value->pivot->new_quantity > 0)
                                                <strong>{{ $value->title }}</strong></label>
                                            
                                            @endif

                                    </td>
                                   
                                    <td class="right_text">
                                        <label class="control-label text_size">
                                            
                                            {{-- First time kitchen receipt print --}}
                                            @if ($value->pivot->new_added_item == 'no' && $value->pivot->new_quantity == 0)
                                                <strong>{{ $value->pivot->quantity }}</strong></label>

                                            {{-- Update but new item added in existing order --}}
                                            @elseif($value->pivot->new_added_item == 'yes' && $value->pivot->new_quantity == 0)
                                                <strong>{{ $value->pivot->quantity }}</strong></label>

                                            {{-- Update but existing item`s quantity is changed --}}
                                            @elseif($value->pivot->new_added_item == 'no' && $value->pivot->new_quantity > 0)
                                                <strong>{{ $value->pivot->new_quantity }}</strong></label>
                                            @endif
                                    </td>
                                    
                                </tr>    
                            
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </div>

</body>


</html>
