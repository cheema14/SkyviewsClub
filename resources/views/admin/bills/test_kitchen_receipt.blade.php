<!-- resources/views/receipt.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
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
                width: 20%;
                height: 20%;
                border-radius: 50%;
                background-color: #EAE4C9;
                border-color: #EAE4C9;
            }

            .btn-cancel {
                width: 20%;
                height: 20%;
                border-radius: 50%;
                background-color: #e2af9e;
                border-color: #F4C1B1;
            }



            @media print {
                body {
                    color: black;
                }

                @page {
                    margin: 0mm !important
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
                                <td colspan="4" style="text-align: center !important;">
                                    <img alt="logo" src="{{ public_path('img/golf-logo.png') }}" width="80">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="center_text ">
                                    <h3>Master KOT</h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="center_text ">
                                    <h4>GO3</h4>
                                </td>
                            </tr>

                            <tr class="center_text">
                                <td colspan="3" class="left_text">
                                    <label style="text-decoration: underline;"
                                        class="control-label text_size hospital_name_class">
                                        31-05-2023 01:38 PM</label>
                                </td>
                                <td style="text-align: left !important;vertical-align: baseline;padding-top: 13px;">
                                    <label style="text-decoration: underline;"
                                        class="control-label "><strong>New</strong></label>
                                </td>
                            </tr>


                            <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Table</strong></label> <span>GO3</span>
                                </td>
                                <td colspan="2"> <label class="control-label text_size">
                                        <strong>Persone: </strong></label> 60
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td colspan="2" class="left_text">
                                    <label class="control-label text_size">
                                        <strong>QOT</strong></label>
                                    <sapn>A</sapn>
                                </td>
                                <td colspan="2"> <label class="control-label text_size">
                                        <strong>QOT Sr: </strong></label>
                                    <sapn>6</sapn>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td colspan="4" class="left_text"> <label class="control-label text_size">
                                        <strong>Remarks:</strong></label></td>
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
                                        <strong>ID:</strong></label>
                                </td>
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Description</strong></label>
                                </td>
                                <td class="right_text" style="width: 10%;">
                                    <label class="control-label text_size">
                                        <strong>QTY</strong></label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="center_text" style=" border-top: 1px solid #000;">
                                    <label class="control-label text_size">
                                        <strong>COLDBAR</strong></label>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>581</strong></label>
                                </td>
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Water Large</strong></label>
                                </td>
                                <td class="right_text">
                                    <label class="control-label text_size">
                                        <strong>1</strong></label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="center_text" style=" border-top: 1px solid #000;">
                                    <label class="control-label text_size">
                                        <strong>First floor</strong></label>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>581</strong></label>
                                </td>
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>CornSoup</strong></label>
                                </td>
                                <td class="right_text">
                                    <label class="control-label text_size">
                                        <strong>1</strong></label>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>75</strong></label>
                                </td>
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Fajita Pizza Medium</strong></label>
                                </td>
                                <td class="right_text">
                                    <label class="control-label text_size">
                                        <strong>1</strong></label>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td colspan="3" class="center_text" style=" border-top: 1px solid #000;">
                                    <label class="control-label text_size">
                                        <strong>Golfers Lounge</strong></label>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>75</strong></label>
                                </td>
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Cream of Chicken Mushroom (Single)</strong></label>
                                </td>
                                <td class="right_text">
                                    <label class="control-label text_size">
                                        <strong>1</strong></label>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>75</strong></label>
                                </td>
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Garlic Bread</strong></label>
                                </td>
                                <td class="right_text">
                                    <label class="control-label text_size">
                                        <strong>1</strong></label>
                                </td>
                            </tr>
                            <tr class="center_text">
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>75</strong></label>
                                </td>
                                <td class="left_text">
                                    <label class="control-label text_size">
                                        <strong>Chicken Sreak</strong></label>
                                </td>
                                <td class="right_text">
                                    <label class="control-label text_size">
                                        <strong>1</strong></label>
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
