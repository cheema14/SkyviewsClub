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
    .dot {
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 10px;
    }
    .pdf-week-btn {
        display: none;
    }
</style>
@endsection
<!-- @can('order_create')
    <div style="margin-bottom: 10px;" class="row">
        @can('order_create')
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.orders.create') }}">
                    {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.order.title_singular') }}
                </a>
            </div>

        @endcan
    </div>
@endcan -->

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans(tenant()->id.'/cruds.order.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>

                {{-- <livewire:CheckUpdateOrder /> --}}
            </div>
        </div>
        <br />
        <div class="row">
            <div class="form-group col-md-4">
                <label for="from_date">From:</label>
                <input type="text" name="from_date" id="from_date" class="form-control from_date" required>
            </div>
        
            <div class="form-group col-md-4">
                <label for="to_date">To:</label>
                <input type="text" name="to_date" id="to_date" class="form-control to_date" value="">
            </div>

            @if (!request()->has('status'))
                <div class="form-group col-md-4">
                    <label>{{ trans(tenant()->id.'/cruds.order.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('orderStatus') ? 'is-invalid' : '' }}" name="orderStatus" id="orderStatus">
                        <option value disabled {{ old('orderStatus', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                        @foreach(App\Models\Order::STATUS_SELECT as $key => $label)
                            @if ($key != 'Paid' && $key != 'Delivered' && $key !='Returned' && $key !='Complete')
                                <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="form-group col-md-12">
                <button type="button" class="btn btn-primary" id="search">Search</button>
                <button type="button" class="btn btn-danger" id="reset">Reset</button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-borderless table-striped table-hover ajaxTable datatable datatable-Order">
            <thead>
                <tr>
                    <th>
                        {{ trans(tenant()->id.'/cruds.order.fields.id') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.tableTop.fields.code') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.order.fields.user') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.order.fields.member') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.membership_no') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.member.fields.cell_no') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.order.fields.status') }}
                    </th>
                     <th>
                        {{ trans(tenant()->id.'/cruds.order.fields.created_at') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.order.fields.total') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.order.fields.grand_total') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.order.fields.payment_type') }}
                    </th>
                    <th>
                        {{ trans(tenant()->id.'/cruds.order.fields.item') }}
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@parent
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    

        dtButtons.push({
            text: 'PDF-Week(Current)',
            className: "btn-primary",
            action: function (e, dt, node, config) {
                // Perform an AJAX request to the server to fetch all data
                $.ajax({
                    url: "{{ route('admin.exportAllPdf') }}", // Your export route here
                    method: 'GET',
                    dataType: 'html',
                    data:{param:'week'},
                    success: function (data) {
                        let response = JSON.parse(data);
                        if (response.file_url) {
                            // Create a hidden anchor element and trigger download
                            var link = document.createElement('a');
                            link.href = response.file_url;
                            link.download = response.file_url.split('/').pop();  // Use filename from URL
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        } else {
                            alert("cannot download pdf. try again!");
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        alert('Failed to export data. Please try again.');
                    }
                });
            }
        });

        dtButtons.push({
            text: 'PDF-Month(Current)',
            className: "btn-warning",
            action: function (e, dt, node, config) {
                // Perform an AJAX request to the server to fetch all data
                $.ajax({
                    url: "{{ route('admin.exportAllPdf') }}", // Your export route here
                    method: 'GET',
                    dataType: 'html',
                    data:{param:'month'},
                    success: function (data) {
                        let response = JSON.parse(data);
                        if (response.file_url) {
                            // Create a hidden anchor element and trigger download
                            var link = document.createElement('a');
                            link.href = response.file_url;
                            link.download = response.file_url.split('/').pop();  // Use filename from URL
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        } else {
                            alert("cannot download pdf. try again!");
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        alert('Failed to export data. Please try again.');
                    }
                });
            }
        });

        dtButtons.push({
            text: 'PDF-Today(Current)',
            className: "btn-info",
            action: function (e, dt, node, config) {
                // Perform an AJAX request to the server to fetch all data
                $.ajax({
                    url: "{{ route('admin.exportAllPdf') }}", // Your export route here
                    method: 'GET',
                    dataType: 'html',
                    data:{param:'today'},
                    success: function (data) {
                        let response = JSON.parse(data);
                        if (response.file_url) {
                            // Create a hidden anchor element and trigger download
                            var link = document.createElement('a');
                            link.href = response.file_url;
                            link.download = response.file_url.split('/').pop();  // Use filename from URL
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        } else {
                            alert("cannot download pdf. try again!");
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        alert('Failed to export data. Please try again.');
                    }
                });
            }
        });

        dtButtons.push({
            text: 'PDF-Filtered Records',
            className: "btn-info pdf-week-btn",
            action: function (e, dt, node, config) {
                
                var checkStatus = @json(request()->has('status'));
                let params = dt.ajax.params();
                var filteredData = dt.rows({ filter: 'applied' }).data().toArray();
                // Or if you are using custom date range filters, capture their values like:
                let startDate = $('#from_date').val(); 
                let endDate = $('#to_date').val(); 
                let status = '';
                if(checkStatus){
                    status = @json(request('status'));
                }
                else{
                    status = $('#orderStatus').val();
                }
                 
                
                $.ajax({
                    url: "{{ route('admin.exportActiveAllPdf') }}", // Your export route here
                    method: 'GET',
                    dataType: 'html',
                    data: {
                        param: 'filter', 
                        start_date: startDate, 
                        end_date: endDate,
                        status:status,
                    },
                    success: function (data) {
                        let response = JSON.parse(data);
                        if (response.file_url) {
                            // Create a hidden anchor element and trigger download
                            var link = document.createElement('a');
                            link.href = response.file_url;
                            link.download = response.file_url.split('/').pop();  // Use filename from URL
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        } else {
                            alert("cannot download pdf. try again!");
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        alert('Failed to export data. Please try again.');
                    }
                });
            }
        });

        
        function htmltopdf(htmlContent) {
            // Create a Blob from the HTML content
            var blob = new Blob([htmlContent], { type: 'text/html' });
            var url = URL.createObjectURL(blob);

            // Create a new iframe to render the PDF
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none'; // Hide the iframe
            document.body.appendChild(iframe);

            // Load the blob URL in the iframe
            iframe.onload = function() {
                // Use html2pdf on the iframe's content
                html2pdf(iframe.contentWindow.document.body, {
                    margin: 1,
                    filename: 'export.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2, logging: true, dpi: 192, letterRendering: false },
                    jsPDF: { unit: 'in', format: 'a0', orientation: 'portrait' }
                }).save().then(() => {
                    // Remove the iframe after the download is initiated
                    document.body.removeChild(iframe);
                    URL.revokeObjectURL(url); // Clean up the Blob URL
                }).catch(err => {
                    console.error(err);
                    alert('Failed to generate PDF. Please try again.');
                    document.body.removeChild(iframe);
                    URL.revokeObjectURL(url); // Clean up the Blob URL
                });
            };

            // Set the src of the iframe to the blob URL
            iframe.src = url;
}
        // function htmltopdf(htmlContent) {
        //     // Create a temporary div to hold the HTML content
            
        //     let element = document.createElement('div');
        //     element.innerHTML = htmlContent;
        //     console.log("HTML",htmlContent);
        //     // Call html2pdf on the element
        //     setTimeout(function() {
        //         html2pdf(htmlContent, {
        //             margin:       1,
        //             filename:     'export.pdf',
        //             image:        { type: 'jpeg', quality: 0.98 },
        //             html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: false },
        //             jsPDF:        { unit: 'in', format: 'a0', orientation: 'portrait' }
        //         }).save();
        //     }, 100); 
        // }

        function generateHTMLTemplate(allOrders) {
            var html = '<html><head><style>/* Add some styling here if needed */</style></head><body>';
            
            allOrders.forEach(function(order) {
                html += '<h2>Order ID: ' + order.id + '</h2>';
                html += '<p>Order Date: ' + order.created_at + '</p>';
                html += '<p>User: ' + order.user.name + '</p>';
                html += '<p>Total Items: ' + order.items.length + '</p>';
                html += '<ul>';
                
                order.items.forEach(function(item) {
                    html += '<li>' + item.title + ' (Quantity: ' + item.pivot.quantity + ')</li>';
                });
                
                html += '</ul><hr>';
                html += '<br>';
            });

            html += '</body></html>';

            return html;
        }

    @can('order_delete')
        let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.orders.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
            });

            if (ids.length === 0) {
                alert('{{ trans(tenant()->id.'/global.datatables.zero_selected') }}')

                return
            }

            if (confirm('{{ trans(tenant()->id.'/global.areYouSure') }}')) {
                $.ajax({
                headers: {'x-csrf-token': _token},
                method: 'POST',
                url: config.url,
                data: { ids: ids, _method: 'DELETE' }})
                .done(function () { location.reload() })
            }
            }
        }
        dtButtons.push(deleteButton)
    @endcan
        var status = @json(request()->status ?? '');
        
        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            // ajax: "{{ route('admin.orders.index',['status' => '"status"']) }}",
            ajax: {
                url: "{{ route('admin.orders.index') }}",
                type: "GET",
                data: function (d) {
                    d.status = status;
                },
                // ... other ajax options
            },
            // ... other ajax options
            columns:[
                    { data: 'id', name: 'id' },
                    { data: 'table_top.code', name: 'tableTop.code' },
                    { data: 'user_name', name: 'user.name' },
                    { data: 'member_name', name: 'member.name' },
                    { data: 'member.membership_no', name: 'member.membership_no' },
                    { data: 'member.cell_no', name: 'member.cell_no' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'total', name: 'total' },
                    { data: 'grand_total', name: 'grand_total' },
                    { data: 'payment_type', name: 'payment_type' },
                    { data: 'item', name: 'items.title' },
                    { data: 'actions', name: '{{ trans(tenant()->id.'/global.actions') }}' }
            ],
            createdRow: (row, data, dataIndex, cells) => {
                $(cells[6]).html('<span style="background-color:'+data.status_color+'" class="dot"></span>'+data.status);
            },
            orderCellsTop: true,
            order: [[ 0, 'desc' ]],
            pageLength: 10,
        },
        table = $('.datatable-Order').DataTable(dtOverrideGlobals);
        
        table.on('draw', function() {
            
            var filteredData = table.rows({ filter: 'applied' }).data();
            // Check if any filters are applied (if the filtered data is less than total rows)
            if (filteredData.length <= table.rows().data().length && $('#from_date').val() != '' && $('#to_date').val()) {
                // because .show displays as block which disrupts the styles
                $('.pdf-week-btn').css('display','inline-block');
            } else {
                // Hide the PDF button if no filters are applied
                $('.pdf-week-btn').hide();
            }
        });

    $(document).on("click","#search",function(){
        let selectedStatus = 'all';
        
        // Get the selected status value
        if($("#orderStatus").val()){
            selectedStatus = $("#orderStatus").val();
        }
        
        
        
        let fromDate = $("#from_date").val();
        let toDate = $("#to_date").val();
        
               
        // Clear the DataTable
        table.clear().draw();
        table.ajax.url("{{ route('admin.orders.index') }}?fromDate="+fromDate+"&toDate="+toDate+"&orderStatus="+selectedStatus).load();
    
    });

    $(document).on("click","#reset",function(){
        reset_form_fields();
        table.clear().draw();
        table.ajax.url("{{ route('admin.orders.index') }}").load();
    });

    function reset_form_fields() {
        $("#orderStatus").val('');
        $("#from_date").val('');
        // $("#to_date").val('');
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

});


$(document).on("click", ".performAction",function(e) {

    setTimeout(function () {
        location.reload(true);
    }, 1000);
});
</script>


<script type="text/javascript">

    setInterval('refreshPage()', 300000);

    function refreshPage() {
        // location.reload();
    }
</script>


@endsection
