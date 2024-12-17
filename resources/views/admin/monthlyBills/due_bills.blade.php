@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@include('partials.'.tenant()->id.'.flash_messages')
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
    #print_all_bills {
        display:none;
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
                {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.title') }}
                </h4>
            </div>
        </div>
        <br />
        
        @if(now()->day >= 5 || app('env') != 'production')
            <div class="row">
                <div class="form-group col-md-4 generate_bills">
                    <label for="billing_month">{{ trans(tenant()->id.'/cruds.monthlyBilling.billing_invoice.billing_month') }}</label>
                    <select class="form-control {{ $errors->has('billing_month') ? 'is-invalid' : '' }}" name="billing_month" id="billing_month" required>
                        <option value disabled {{ old('billing_month', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                            @foreach(App\Models\Bill::BILLING_MONTHS as $key => $label)
                            {{-- Display only current month --}}
                            @if ($key == now()->format('m')) 
                                    <option value="{{ $key }}" {{ old('billing_month', '') === (string) $key ? 'selected' : '' }}>{{ $label }} - {{ date('Y') }}</option>
                                @endif
                            @endforeach 
                    </select>
                </div>
                <div class="form-group col-md-4 generate_bills">
                    <label for="invoice_due_date">{{ trans(tenant()->id.'/cruds.monthlyBilling.billing_invoice.invoice_due_date') }}</label>
                    <input type="text" name="invoice_due_date" id="invoice_due_date" class="form-control" value="">
                </div>
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary generate_bills" id="loadDueBills">Load Bills</button>
                    <button type="button" class="btn btn-danger" id="resetDueBills">Reset</button>
                </div>
            </div>
        @else
            <p style="color: red;font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">This month's bills have not been generated yet. They will be generated on the 5th. You can view previous months' bills in the Old Bills list.</p>
        @endif
        <div class="row" style="display:none;">
            <div class="form-group col-md-4">
                <label for="membership_no">{{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.membership_no') }}</label>
                <input type="text" maxlength="10" name="membership_no" id="membership_no" class="form-control" value="">
            </div>
            <div class="form-group col-md-4">
                <label for="membership_status">{{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.membership_status') }}</label>
                <select class="form-control {{ $errors->has('membership_status') ? 'is-invalid' : '' }}" name="membership_status" id="membership_status">
                    <option value disabled {{ old('membership_status', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Member::MEMBERSHIP_STATUS_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-12">
                <button type="button" class="btn btn-primary" id="search">Search</button>
                <button type="button" class="btn btn-danger" id="reset">Reset</button>
            </div>
        </div>

        

    </div>

    <div class="card-body">
        <div class="form-group col-md-12">
            <button type="button" class="btn btn-primary" id="print_all_bills">Print All Bills</button>
        </div>
            <table class=" table table-borderless table-striped table-hover datatable datatable-due-bills">
                <thead>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.member_name') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.membership_no') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.cnic') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.father_husband_name') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.membership_status') }}
                        </th>
                        {{-- <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.arrears') }}
                        </th> --}}
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.total_invoice_amount') }}
                        </th>
                        {{-- <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.total_billing_amount') }}
                        </th> --}}
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.remaining_balance') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.invoice_month') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.due_date') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.invoice_status') }}
                        </th>
                        <th class="text-center">
                            {{ trans(tenant()->id.'/cruds.monthlyBilling.dueBills.actions') }}
                        </th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @foreach($monthly_bills_data as $key => $monthlyMemberdata)
                        <tr data-entry-id="{{ $monthlyMemberdata->id }}">
                            <td class="text-center">
                                {{ $monthlyMemberdata->id ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $monthlyMemberdata->name ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $monthlyMemberdata->membership_no ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $monthlyMemberdata->cnic_no ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $monthlyMemberdata->husband_father_name ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $monthlyMemberdata->membership_status ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $monthlyMemberdata->arrears ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $monthlyMemberdata->total_bill ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $monthlyMemberdata->billing_month ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $monthlyMemberdata->due_date ?? 'N/A' }}
                            </td>
                            <td class="text-center">
                                Unpaid
                            </td>
                            <td class="text-center">
                                Actions
                            </td>

                        </tr>
                    @endforeach
                </tbody> --}}
            </table>
    </div>
</div>
<div class="overlay"></div>
@endsection
@section('scripts')
@parent
<script>
    // $(function () {
        // Search and reset methods for the table

        $(document).on("click","#search",function(){
            // Get the selected status value
            let membership_no = $("#membership_no").val();
            let membership_status = $("#membership_status").val();
            
            // Clear the DataTable
            table.clear().draw();
            table.ajax.url("{{ route('admin.monthlyBilling.get-due-bills') }}?membership_status=" + membership_status + "&membership_no="+membership_no).load();
            
        });
            
        $(document).on("click","#reset",function(){
            reset_form_fields();
            table.clear().draw();
            table.ajax.url("{{ route('admin.monthlyBilling.get-due-bills') }}").load();
        });


        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });



    

        $(document).on("change","#billing_month",function(){
            
            let billing_month = $("#billing_month").val();
            let lastDay = new Date(new Date().getFullYear(), billing_month, 0).getDate();
            // let fifteenthDay = new Date(year, month, 15);
            // lastDay = fifteenthDay;
            let monthNames = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ];
            
            // because array index starts from 0
            // month value starts from 1 inside the model Bill.php
            // so minus 1 is needed

            let month = monthNames[billing_month - 1];

            let year = new Date().getFullYear();
            
            $("#invoice_due_date").val(lastDay+"-"+month+"-"+year);
            
        });


        // After generating bills
        // hide or disable the generate bill params

        $(document).on("click","#loadDueBills",function(){
            
            
            if($("#billing_month").val() == '' || $("#billing_month").val() == null){
                alert('Select Month to load due bills');
                $("#print_all_bills").hide();
                return false;
            }
            
            //  Load data with datatables
            generate_datatable_due_bills();
            
        });

        $(document).on("click","#resetDueBills",function(){
            window.location.reload();
            $("#billing_month").val();
            $("#invoice_due_date").val();
            $("#print_all_bills").hide();
        });

    // }) // end function of table

    function generate_datatable_due_bills(){


            // let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        
            var month = $("#billing_month").val();
            var invoiceDueDate = $("#invoice_due_date").val();
            

            let dtOverrideGlobals = {
                // buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ordering:true,
                columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'membership_no', name: 'membership_no' },
                        { data: 'cnic_no', name: 'cnic_no' },
                        { data: 'husband_father_name', name: 'husband_father_name' },
                        { data: 'membership_status', name: 'membership_status' },
                        // { data: 'arrears', name: 'arrears' },
                        // { data: 'total_bill', name: 'total_bill' },
                        { data: 'total_bill', name: 'total_bill' },
                        { data: 'net_balance_payable', name: 'net_balance_payable' },
                        { data: 'billing_month', name: 'billing_month' },
                        { data: 'due_date', name: 'due_date' },
                        { data: 'bill_status', name: 'bill_status' },
                        { data: 'actions.actions', name: '{{ trans(tenant()->id.'/global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [[ 0, 'desc' ]],
                pageLength: 10,
                initComplete: function () {
                    // This function is called when the DataTable has finished its initialization
                    // You can show your button here
                    $("#print_all_bills").show();
                }
            };
            
            let table = $('.datatable-due-bills').DataTable(dtOverrideGlobals);
            table.ajax.url("{{ route('admin.monthlyBilling.get-due-bills') }}?month=" + month + "&invoiceDueDate=" + invoiceDueDate).load();
    }

    $(document).on("click","#print_all_bills",function(){
            
        $("body").addClass("loading"); 

            $.ajax({
                type:'GET',
                url:'{{ route('admin.monthlyBilling.download-all-bills') }}',
                headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                    },
                data:{ billing_date: $("#invoice_due_date").val()},
                success:function(response) {
                    $("body").removeClass("loading");
                    var zipFileName = response.zipFileName;
                    var zipFileUrl = '/storage/' + zipFileName;
                    var link = document.createElement('a');
                    link.href = zipFileUrl;
                    link.download = 'invoices.zip';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link); 
                },
                complete:function(data){
                    $("body").removeClass("loading");
                }
            });

    });
</script>
@endsection