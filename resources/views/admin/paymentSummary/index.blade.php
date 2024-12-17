@extends('layouts.admin')
@section('content')
@include('partials.flash_messages')
@section('styles')
<style>
    .dataTables_scrollBody, .dataTables_wrapper {
        position: static !important;
    }
    .dropdown-button {
        cursor: pointer;
        font-size: 2em;
        display:block
    }
    .dropdown-menu i {
        font-size: 1.33333333em;
        line-height: 0.75em;
        vertical-align: -15%;
        color: #000;
    }
    .datatable-payment-summary{
        display: block;
    overflow-x: auto;
    white-space: nowrap;
    }
    .overlay{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) url("/examples/images/loader.gif") center no-repeat;
    }
    
    /* Turn off scrollbar when body element has the loading class */
    body.loading{
        overflow: hidden;   
    }
    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay{
        display: block;
    }
</style>
@endsection
    <div class="card">
        <span class="loader"></span>
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4>
                    {{ trans('cruds.paymentSummary.title') }}
                    </h4>
                </div>
            </div>
            <br />

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="payment_summary_from_date">{{ trans('cruds.paymentSummary.payment_summary_from_date') }}</label>
                    <input type="text" name="payment_summary_from_date" id="payment_summary_from_date" class="form-control payment_summary_from_date" value="">
                </div>
                <div class="form-group col-md-4">
                    <label for="payment_summary_to_date">{{ trans('cruds.paymentSummary.payment_summary_to_date') }}</label>
                    <input type="text" name="payment_summary_to_date" id="payment_summary_to_date" class="form-control payment_summary_to_date" value="">
                </div>
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary generate_bills" id="loadPaymentSummary">Load</button>
                    <button type="button" class="btn btn-danger" id="resetPaymentSummary">Reset</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class=" table table-borderless table-striped table-hover datatable datatable-payment-summary">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.SrNo') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.MNo') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.rank') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.dob') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.age') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.paymentSummary.tableFields.bal_bf_dr') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.bal_bf_cr') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.monthly_subscription') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.caddy_welfare') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.locker_fee') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.paymentSummary.tableFields.caddy_fee') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.match_fee') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.card_fee') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.cart_fee') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.paymentSummary.tableFields.grenfee') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.restaurant') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.range') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.others') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.total_bill') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.paymentSummary.tableFields.adjustment') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.paymentSummary.tableFields.amount_paid') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.paymentSummary.tableFields.date') }}
                        </th> --}}
                        {{-- <th>
                            {{ trans('cruds.paymentSummary.tableFields.bal_cf_dr') }}
                        </th> --}}
                        {{-- <th>
                            {{ trans('cruds.paymentSummary.tableFields.bal_cf_cr') }}
                        </th> --}}
                        
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="overlay"></div>
@endsection
@section('scripts')
@parent
<script>
    $(".payment_summary_from_date").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        minDate: new Date(),
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    $(".payment_summary_to_date").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
        useCurrent: false,
    });

    // Prevent checkout date from being before the selected check-in date
    $(".payment_summary_from_date").on("dp.change", function (e) {
        $(".payment_summary_to_date").data("DateTimePicker").minDate(e.date);
    });

    // Prevent check-in date from being after the selected check-out date
    $(".payment_summary_to_date").on("dp.change", function (e) {
        $(".payment_summary_from_date").data("DateTimePicker").maxDate(e.date);
    });
</script>

<script>

        $(document).on("click","#loadPaymentSummary",function(){
            
            
            if($("#payment_summary_from_date").val() == ''){
                alert('Select From dates.');
                return false;
            }

            if($("#payment_summary_to_date").val() == ''){
                alert('Select To dates.');
                return false;
            }
            
            //  Load data with datatables
            generate_datatable_payment_summary();
            
        });

        $(document).on("click","#resetPaymentSummary",function(){
            window.location.reload();
            $("#payment_summary_from_date").val();
            $("#payment_summary_to_date").val();
        });

    
    function generate_datatable_payment_summary(){


            // let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        
            var from_date = $("#payment_summary_from_date").val();
            var to_date = $("#payment_summary_from_date").val();
            

            let dtOverrideGlobals = {
                // buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ordering:true,
                columns: [
                        { data: 'id', name: 'id' },
                        { data: 'membership_no', name: 'membership_no' },
                        { data: 'membership_type.name', name: 'membership_type' },
                        { data: 'name', name: 'name' },
                        { data: 'date_of_birth', name: 'date_of_birth' },
                        { data: 'member_age', name: 'member_age' },
                        { data: 'latest_bill.balance_bfcr', name: 'latest_bill.balance_bfcr', defaultContent: 'N/A' },
                        { data: 'membership_type.subscription_fee', name: 'membership_type.subscription_fee',defaultContent: 'N/A' },
                        { data: 'latest_bill.caddies_fee', name: 'latest_bill.caddies_fee',defaultContent: 'N/A' },
                        { data: 'latest_bill.locker_fee', name: 'latest_bill.locker_fee',defaultContent: 'N/A' },
                        { data: 'latest_bill.club_golf_match_fee', name: 'latest_bill.club_golf_match_fee',defaultContent: 'N/A' },
                        { data: 'latest_bill.card_fee', name: 'latest_bill.card_fee',defaultContent: 'N/A' },
                        { data: 'latest_bill.cart_fee', name: 'latest_bill.cart_fee',defaultContent: 'N/A' },
                        { data: 'latest_bill.restaurant_fee', name: 'latest_bill.restaurant_fee',defaultContent: 'N/A' },
                        { data: 'latest_bill.practice_range_coaching_fee', name: 'latest_bill.practice_range_coaching_fee',defaultContent: 'N/A' },
                        { data: 'latest_bill.fee', name: 'latest_bill.fee',defaultContent: 'N/A' },
                        { data: 'latest_bill.total', name: 'latest_bill.total',defaultContent: 'N/A' },
                        { data: 'latestPayments.received_amount', name: 'latestPayments.received_amount',defaultContent: 'N/A' },
                        // { data: 'membership_type.name', name: 'membership_type.name' },
                        // { data: 'membership_type.name', name: 'membership_type.name' },
                        // { data: 'membership_type.name', name: 'membership_type.name' },
                        // { data: 'membership_type.name', name: 'membership_type.name' },
                        // { data: 'membership_type.name', name: 'membership_type.name' },
                        // { data: 'membership_type.name', name: 'membership_type.name' },
                        // { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [[ 0, 'desc' ]],
                pageLength: 10,
                initComplete: function () {
                    // This function is called when the DataTable has finished its initialization
                    // You can show your button here
                    
                }
            };
            
            let table = $('.datatable-payment-summary').DataTable(dtOverrideGlobals);
            table.ajax.url("{{ route('admin.paymentSummary.view-payment-summary') }}?from_date=" + from_date + "&to_date=" + to_date).load();
    }

</script>
@endsection