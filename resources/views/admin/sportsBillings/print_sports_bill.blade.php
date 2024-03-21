<!DOCTYPE html>
<!-- saved from url=(0042)http://127.0.0.1:8000/patient/visit-report -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sports Bill Receipt</title>
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
                                <td colspan="2" style="text-align: center !important;">
                                    <img alt="logo" src="{{ asset('img/golf-logo.png') }}" width="80">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="center_text ">
                                    <h3>{{ trans('global.project_title') }}</h3>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td colspan="2" style="border-top: 2px dotted;"></td>
                            </tr>

                            <tr class="center_text">
                                <td class="left_text">
                                    <label style="text-decoration: underline;"
                                        class="control-label text_size hospital_name_class">
                                        Bill No:{{ $data->id }}</label>
                                </td>
                                <td class="left_text" >
                                    <label style="text-align:right;line-height: 17px;"
                                        class="control-label "><strong>Bill Date:</strong><span> {{ date("d-m-Y H:i:s",strtotime($data->created_at)) }}</span></label>
                                </td>
                            </tr>

                            


                            <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Server</strong></label>{{ '  ' }}<span>Sports Section</span>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td colspan="2" class="left_text"> <label class="control-label text_size">
                                        <strong>Remarks</strong></label></td>
                            </tr>
                            
                         
                        </tbody>
                    </table>
                    <table style="border-top:none;">
                        <tbody>
                            <tr class="left_text">
                                <td class="left_text" style="width: 6%;">
                                    <label class="control-label text_size">
                                        <strong>Sr#</strong></label>
                                </td>
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Item Description</strong></label>
                                </td>
                                <td class="right_text" style="width: 10%;">
                                    <label class="control-label text_size">
                                        <strong>QTY</strong></label>
                                </td>
                                <td class="right_text" style="width: 10%;">
                                    <label class="control-label text_size">
                                        <strong>Price</strong></label>
                                </td>
                                <td class="right_text" style="width: 10%;">
                                    <label class="control-label text_size">
                                        <strong>Total</strong></label>
                                </td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="5" style="border-top: 2px dotted;"></td>
                            </tr>
                            @foreach ($data->sportBillingSportBillingItems as $value)

                                <tr class="center_text">
                                    <td class="left_text">
                                        <label class="control-label text_size">
                                            <strong>{{ $loop->iteration }}</strong></label>
                                    </td>
                                    <td class="left_text">
                                        <label class="control-label text_size">
                                            <strong>{{ $value->billing_item_name->item_name }}</strong></label>
                                    </td>
                                    <td class="right_text">
                                        <label class="control-label text_size">
                                            <strong>{{ $value->quantity }}</strong></label>
                                    </td>
                                    <td class="right_text">
                                        <label class="control-label text_size">
                                            <strong>{{ $value->rate }}</strong></label>
                                    </td>
                                    <td class="right_text">
                                        <label class="control-label text_size">
                                            <strong>{{ $value->amount }}</strong></label>
                                    </td>
                                </tr>
                                
                                <td colspan="5" style="border-top: 2px solid black;"></td>
                            @endforeach
                            <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <strong><label style=""
                                        class="control-label ">
                                        Gross Amount:</label></strong>
                                </td>
                                <td colspan="3" > <span> {{ $gross_total }} </span> </td>
                            </tr>
                            @if ($data->pay_mode == 'card')
                                <tr class="center_text">
                                    <td colspan="2" class="left_text">
                                        <strong><label style=""
                                            class="control-label ">
                                            Bank Charges:</label></strong>
                                    </td>
                                    <td colspan="3" > <span> {{ $data->bank_charges }} </span> </td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="2" class="left_text">
                                    <label style="text-align:right;"
                                        class="control-label "><strong>Net Payable Amount:</strong></label>
                                        
                                </td>
                                <td colspan="3" > <span>{{ $net_payable }}</span> </td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="2" class="left_text" style="vertical-align: top;">
                                    <strong><label style=""
                                        class="control-label">
                                        Membership No:</label></strong>
                                        <span style="line-height: 20px;display:block;">{{ $data->membership_no }}</span>
                                </td>
                                <td colspan="3" class="right_text">
                                    <strong><label style=""
                                        class="control-label">
                                        Prepared By:</label></strong>
                                        <span style="line-height: 20px;">{{ $prepared_by }}</span>
                                </td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="5" class="left_text" style="vertical-align: top;padding-top:0;">
                                    <strong><label style=""
                                        class="control-label">
                                        Member Name:</label></strong> 
                                        <span style="line-height: 20px;">{{ $data->member_name ?? $data->non_member_name }}</span>
                                </td>
                                
                            </tr>

                            <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <label style=""
                                        class="control-label">
                                        Pay Mode:</label> 
                                        <span><strong>{{ ucfirst($data->pay_mode) }}</strong></span>
                                </td>
                                <td colspan="3" class="right_text">
                                    <label style=""
                                        class="control-label">
                                        </label>
                                        <span><strong>{{ date("d-m-Y H:i:s") }}</strong></span>
                                </td>
                            </tr>
                            
                            {{-- <tr class="center_text">
                                <td colspan="4" style="border-top: 2px dotted;"></td>
                            </tr> --}}
                            
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </div>

</body>

</html>
