<!DOCTYPE html>
<!-- saved from url=(0042)http://127.0.0.1:8000/patient/visit-report -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Receipt</title>
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
                                    <img alt="logo" src="{{ asset('img/'.tenant()->id.'/new_logo.png') }}" width="80">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="center_text" style="line-height: 1.5">
                                    <h2>{{ trans(tenant()->id.'/global.project_title_for_slip') }}</h2>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td colspan="2" class="center_text ">
                                    <h3>{{ trans('global.project_title_for_slip') }}</h3>
                                </td>
                            </tr> --}}
                            <tr class="center_text">
                                <td colspan="2" style="border-top: 2px dotted;"></td>
                            </tr>

                            <tr class="center_text">
                                <td class="left_text">
                                    <label style="text-decoration: underline;"
                                        class="control-label text_size hospital_name_class">
                                        Receipt No:{{ $payment_receipt->id }}</label>
                                </td>
                                <td class="left_text" >
                                    <label style="text-align:right;line-height: 17px;"
                                        class="control-label "><strong>Date:</strong><span> {{ date("d-m-Y",strtotime($payment_receipt->created_at)) }}</span></label>
                                </td>
                            </tr>

                            


                            {{-- <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Server</strong></label>{{ '  ' }}<span>Sports Section</span>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td colspan="2" class="left_text"> <label class="control-label text_size">
                                        <strong>Remarks</strong></label></td>
                            </tr> --}}
                            
                         
                        </tbody>
                    </table>
                    <table style="vertical-align: top;">
                        <tbody>
                            <tr class="center_text">
                                @if ($payment_receipt->bill)
                                    <td colspan="2" class="left_text">
                                        <strong><label style=""
                                            class="control-label ">
                                            Total Amount:</label></strong>
                                    </td>
                                    <td colspan="3" > <span> {{ $payment_receipt->bill?->total }} </span> </td>
                                @endif
                            </tr>
                            
                            <tr>
                                <td colspan="2" class="left_text">
                                    <label style="text-align:right;"
                                        class="control-label "><strong>Received Amount:</strong></label>       
                                </td>
                                <td colspan="3" > <span>{{ $payment_receipt->received_amount }}</span> </td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="2" class="left_text" style="vertical-align: top;">
                                    <strong><label style=""
                                        class="control-label">
                                        Membership No:</label></strong>
                                        <span style="line-height: 20px;display:block;">{{ $payment_receipt->member?->membership_no }}</span>
                                </td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="2" class="left_text" style="vertical-align: top;padding-top:0;">
                                    <strong><label style=""
                                        class="control-label">
                                        Member Name:</label></strong> 
                                        <span style="line-height: 20px;">{{ $payment_receipt->member?->name ?? $payment_receipt->member?->non_member_name }}</span>
                                </td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <strong><label style=""
                                        class="control-label">
                                        Prepared By:</label></strong>
                                        <span style="line-height: 20px;">{{ $prepared_by }}</span>
                                </td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <label style=""
                                        class="control-label">
                                        Pay Mode:</label> 
                                        <span><strong>{{ ucfirst($payment_receipt->pay_mode) }}</strong></span>
                                </td>
                                <td colspan="3" class="right_text">
                                    <label style=""
                                        class="control-label">
                                        </label>
                                        <span><strong>{{ date("d-m-Y H:i:s") }}</strong></span>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td colspan="4" class="right_text">
                                    <label style=""
                                        class="control-label">
                                        </label>
                                        <span><strong><p style="color:red">For Billing Queries:</strong></span>
                                        <span><strong><p style="color:red">0323-9420064</strong></span>
                                        <span><strong><p style="color:red">0423-7169477</strong></span>
                                        <span><strong><p style="color:red">Thanks for payment</strong></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </div>

</body>

</html>
