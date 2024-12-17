<!DOCTYPE html>
<!-- saved from url=(0042)http://127.0.0.1:8000/patient/visit-report -->
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Report</title>
        </head>
        <body>

<div id="receiptDiv" class="">
    <style>
    th,
    td {
        white-space: normal
    }

    .modal-dialog {
        width: 300px;
        /*height: 113% ;*/
        margin: 5px auto;
    }

    .modal-content {
        height: 100% !important;
    }

    .borderframe table {
        border-collapse: collapse;
        width: 100%;
        /*width: 451px !important;*/
        table-layout: fixed;
    }

    .borderframe tr td {
        text-align: right !important;
        line-height: 10px;
        padding: 6px 10px;
        white-space: -o-pre-wrap;
        word-wrap: break-word;
        /*white-space: pre-wrap;*/
        white-space: -moz-pre-wrap;
        white-space: -pre-wrap;
        font-size: 12px;
        font-family: sans-serif;
        font-weight: 500;
        /*border: 1px #000 solid;*/
    }

    .borderframe table,
    th {
        font-weight: bold;
        border: 1px #000 solid;
        padding: 12px;
    }

    /*tr:nth-child(even) {background-color: #f2f2f2;}*/
    .borderframe h1 {
        text-align: center;
    }

    .borderframe h3 {
        color: black;
    margin: 0;
    line-height: 20px;
    font-size: 20px;
    }
    .borderframe h4 {
        color: black;
    line-height: 20px;
    font-size: 18px;
    border-radius: 50%;
    border: 1px solid #ddd;
    width: 70px;
    margin: auto;
    padding: 5px;

    }
    .borderframe {
        /* width: 451px; */
        /*        height: 496px ;*/
        padding-bottom: 0px;
        /* margin-left: 15px; */
        margin-bottom: 5px;
    }

    .borderframe hr {
        display: block;
        height: 1px;
        background: transparent;
        width: 100%;
        border: none;
        border-top: solid 1px #aaa;
        margin: 0px !important;
    }

    .borderframe .left_text {
        text-align: left !important;
    }

    .borderframe .text_size {
        font-size: 12px;
        font-weight: normal;
        line-height: 1.25;
    }

    .hospital_name_class {

        line-height: 20px;
        font-size: 14px !important;
        font-weight: 700 !important;
    }

    .borderframe .center_text {
        text-align: center !important;
    }

    .borderframe .hosp_text {
        font-size: 14px;
        /* text-decoration: underline; */
        border: 1px solid;
        line-height: 25px;
        padding: 5px;
    }

    .borderframe .default_line_height {
        line-height: 20px;
    }

    .btn-reset {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #EAE4C9;
        border-color: #EAE4C9;
    }

    .btn-cancel {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #e2af9e;
        border-color: #F4C1B1;
    }



    @media  print {
        body {
            color: black;
        }
        @page{
            margin:0mm !important
        }
        .scaled {
            /* transform: scale(0.9); */
            transform-origin: left top;
            margin: 0 8px;
        }

        .hospital_name_class {
            font-size: 9px !important;
            font-weight: 700 !important;
        }


    }
</style>
<div class="modal-dialog " style="">
    <div class="modal-content">

        <div class="row borderframe scaled">

            <table style="vertical-align: top;">
                <tbody>
                    <tr>
                        <td colspan="6" style="text-align: center !important;">
                            <img alt="logo" src="{{ asset('img/pcom/pcom-logo.png') }}" width="80"></td>
                    </tr>
                    <tr>

                        <td colspan="6" class="center_text ">
                         <h3>{{ env('APP_NAME') }}</h3>
                        </td>
                    </tr>
                    {{-- <tr>
                        <td colspan="6" class="center_text ">
                           <p>Golfers Lounge</p>
                        </td>
                    </tr> --}}

                    <tr  class="center_text">
                        <td  colspan="6" style="border-top: 2px dotted;"></td>
                    </tr>


                <tr class="center_text">
                    <td colspan="3" class="left_text">
                         <label class="control-label text_size">
                        <strong>Booking No</strong></label> <span>{{ $roomBooking->id }}</span>
                    </td>
                    <td colspan="3"> <label class="control-label text_size">
                        <strong>Booking Date: </strong></label> {{ now()->format('Y-m-d h:i A') }}</label>
                    </td>
                </tr>
                <tr class="center_text">
                    {{-- <td colspan="6" class="left_text">
                         <label class="control-label text_size">
                        <strong>Area</strong></label> <sapn>DO4</sapn>
                    </td> --}}
                </tr>
                {{-- <tr class="center_text">
                    <td colspan="6" class="left_text">
                         <label class="control-label text_size">
                        <strong>Server</strong></label> <sapn>{{ $order->user?->name }}</sapn></td>

                </tr>
                <tr  class="center_text">
                    <td colspan="6" class="left_text"> <label class="control-label text_size">
                        <strong>Remarks:</strong></label></td>
                </tr> --}}

                <tr  class="center_text">
                    <td  colspan="6" style="border-top: 2px dotted;"></td>
                </tr>


                <tr class="left_text" style="border-bottom: 2px solid;">
                    <td  class="left_text" style="width: 30px;">
                         <label class="control-label text_size">
                          <strong>Sr#</strong></label>
                    </td>
                    <td colspan="2" class="left_text">
                        <label class="control-label text_size">
                         <strong>Room Type</strong></label>
                    </td>
                         <td  class="right_text">
                         <label class="control-label text_size">
                        <strong>Days</strong></label>
                    </td>
                    <td  class="right_text">
                        <label class="control-label text_size">
                       <strong>Unit Price</strong></label>
                   </td>
                   <td  class="right_text">
                        <label class="control-label text_size">
                    <strong style="font-size:10px;">Amount</strong></label>
                    </td>
                </tr>

                    <tr class="center_text">
                        <td class="left_text">
                            <label class="control-label text_size">
                            <strong>1</strong></label>
                        </td>
                            <td colspan="2" class="left_text">
                                <label class="control-label text_size">
                            <strong>{{ $roomBooking->room_type }}</strong></label>
                            </td>
                            <td class="right_text">
                                <label class="control-label text_size">
                            <strong>{{ $roomBooking->no_of_days }}</strong></label>
                            </td>
                            <td class="right_text">
                                <label class="control-label text_size">
                            <strong style="font-size:10px;">{{ $roomBooking->price_at_booking_time }}</strong></label>
                            </td>
                            <td class="right_text">
                                <label class="control-label text_size">
                            <strong style="font-size:10px;">{{ $roomBooking->total_price }}</strong></label>
                            </td>
                    </tr>

                


                <tr class="center_text" style="border-top: 2px solid;">
                    <td colspan="5" class="left_text">
                         <label class="control-label text_size">
                        <strong>Gross Amount:</strong></label>
                    </td>
                        <td  class="left_text">
                            <label class="control-label text_size">
                           <strong style="font-size:10px;">{{ $roomBooking->total_price }}</strong></label>
                        </td>

                </tr>

                @if (false)
                    <tr class="center_text" style="border-top: 2px solid;">
                        <td colspan="5" class="left_text">
                            <label class="control-label text_size">
                            <strong>Bank Charges:</strong></label>
                        </td>
                            <td  class="left_text">
                                <label class="control-label text_size">
                            <strong>{{ $order->tax }}</strong></label>
                            </td>

                    </tr>
                @endif

                <tr class="center_text">
                    <td colspan="5" class="left_text">
                         <label class="control-label text_size">
                        <strong>Net Payable Amount:</strong></label>
                    </td>
                        <td class="left_text" style="padding:6px 9px !important;">
                            <label class="control-label text_size">
                           <strong style="font-size:10px;">{{ number_format(round($roomBooking->total_price))  }}</strong></label>
                        </td>

                </tr>

                <tr class="center_text">
                    <td colspan="3" class="left_text">
                         <label class="control-label text_size">
                        <strong>Membership No</strong></label> <span>{{ $roomBooking->member->membership_no }}</span>
                    </td>
                    <td colspan="3">
                        <label class="control-label text_size">
                       <strong>Prepared By</strong></label> <span>{{ auth()->user()->name }}</span>
                   </td>

                </tr>

                <tr class="center_text">
                    <td colspan="3" class="left_text"> <label class="control-label text_size">
                        <strong></strong></label>
                    </td>
                    <td colspan="3"> <label class="control-label text_size">
                        <strong>{{ now()->format('Y-m-d h:i A') }} </strong></label>
                    </td>
                </tr>
                <tr class="center_text">
                    <td colspan="2" class="left_text" style="border-top: 2px dotted;">
                         <label class="control-label text_size">
                        <strong>Signature </strong></label>
                    </td>

                </tr>
                {{-- <tr class="center_text">
                    <td colspan="6" class="left_text" style="padding-top: 30px;">
                        <label class="control-label text_size">
                        <strong>PayMode: {{ $order->latestTransaction->type }}</strong></label>
                    </td>

                </tr> --}}
            </tbody></table>


        </div>
    </div>
</div>

</div>

</body>
</html>
