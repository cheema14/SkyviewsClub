@extends('layouts.'.tenant()->id.'.admin')
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
</style>
@endsection
@section('content')
@include('partials.'.tenant()->id.'.flash_messages')    
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4>
                {{ trans(tenant()->id.'/cruds.employee.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
                </h4>
            </div>
            @can('employee_create')
            <div class="col-sm-6 ml-auto text-sm-right">
                <a class="btn btn-info px-4"  href="{{ route('admin.employees.create') }}">
                {{ trans(tenant()->id.'/global.add') }} {{ trans(tenant()->id.'/cruds.employee.title_singular') }}
                </a>
            </div>
            @endcan
            @can('csv_import')
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans(tenant()->id.'/global.app_csvImport') }}
                </button>
            @endcan
        </div>

    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-borderless table-striped table-hover datatable datatable-Employee">
                <thead>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.id') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.name') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.father_name') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.phone') }}
                        </th>
                        <th>
                            {{ trans(tenant()->id.'/cruds.employee.fields.designation') }}
                        </th>
                        <th class="text-center">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $key => $employee)
                        <tr data-entry-id="{{ $employee->id }}">
                            
                            <td>
                                {{ $employee->id ?? '' }}
                            </td>
                            <td>
                                {{ $employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $employee->father_name ?? '' }}
                            </td>
                            <td>
                                {{ $employee->phone ?? '' }}
                            </td>
                            <td>
                                {{ $employee->designation ?? '' }}
                            </td>
                            <td>
                                <div class="dropdown text-center">
                                    <a class="dropdown-button" id="dropdown-menu-{{ $employee->id }}" data-toggle="dropdown" data-boundary="body" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-menu-{{ $employee->id }}">
                                        
                                        @can('employee_show')
                                            <a class="dropdown-item" href="{{ route('admin.employees.show', $employee->id) }}">
                                                <i style="margin-right:10px; " class="fa fa-eye"></i>
                                                {{ trans(tenant()->id.'/global.view') }}
                                            </a>
                                        @endcan

                                        @can('employee_edit')
                                            <a class="dropdown-item" href="{{ route('admin.employees.edit', $employee->id) }}">
                                                <i style="margin-right:10px; " class="fa fa-edit"></i>
                                                {{ trans(tenant()->id.'/global.edit') }}
                                            </a>
                                        @endcan

                                        @can('employee_dependent_create')
                                            <a class="dropdown-item" href="{{ route('admin.employee.dependents.create', $employee->id) }}">
                                                <i style="margin-right:10px; " class="fa fa-plus"></i>
                                                {{ trans(tenant()->id.'/cruds.dependent.fields.create_dependent') }}
                                            </a>
                                        @endcan

                                        @can('employee_dependent_list')
                                            <a class="dropdown-item" href="{{ route('admin.employee.dependents.list',$employee->id) }}">
                                                <i style="margin-right:10px; " class="fa fa-eye fa-lg"></i>
                                                {{ trans(tenant()->id.'/cruds.dependent.fields.list_dependent') }}
                                            </a>
                                        @endcan

                                        @can('employee_delete')
                                            
                                            <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="dropdown-item" value="{{ trans(tenant()->id.'/global.delete') }}">
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('employee_delete')
    let deleteButtonTrans = '{{ trans(tenant()->id.'/global.datatables.delete') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.employees.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
        var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
            return $(entry).data('entry-id')
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

    $.extend(true, $.fn.dataTable.defaults, {
        orderCellsTop: true,
        order: [[ 0, 'desc' ]],
        pageLength: 100,
    });
    let table = $('.datatable-Employee:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    // $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
    //     $($.fn.dataTable.tables(true)).DataTable()
    //         .columns.adjust();
    // });

})

    $('.dropdown-button').on('click', function (e) {
        e.stopPropagation(); // Prevents any bubbling issues
        $(this).closest('.datatable-container').css('overflow', 'visible');
    });

    $('.dropdown-toggle').dropdown({
        flip: false // Prevents auto-flipping, which might cause layout shifts
    });
</script>
@endsection
