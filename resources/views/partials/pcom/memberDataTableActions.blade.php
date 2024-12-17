{{-- @can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans(tenant()->id.'/global.view') }}
    </a>
@endcan
@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans(tenant()->id.'/global.edit') }}
    </a>
@endcan
@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans(tenant()->id.'/global.delete') }}">
    </form>
@endcan

@can('dependent_create')
    <a class="btn btn-xs btn-success" href="{{ route('admin.dependents.create', $row->id) }}">
        {{ trans(tenant()->id.'/cruds.dependent.fields.create_dependent') }}
    </a>
@endcan

@can('dependent_list')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.dependents.index', $row->id) }}">
        {{ trans(tenant()->id.'/cruds.dependent.fields.list_dependent') }}
    </a>
@endcan

<a class="btn btn-xs btn-primary" href="{{ route('admin.view-monthly-bill', $row->id) }}">
    {{ trans(tenant()->id.'/cruds.member.fields.monthly_bill') }}
</a> --}}

<div class="dropdown text-center">
    <a class="dropdown-button" id="dropdown-menu-{{ $row->id }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-v"></i>
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdown-menu-{{ $row->id }}">
        @can($viewGate)
            <a class="dropdown-item" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-eye fa-lg"></i>
                {{ trans(tenant()->id.'/global.view') }}
            </a>
        @endcan

        @can($editGate)
            <a class="dropdown-item" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-edit"></i>
                {{ trans(tenant()->id.'/global.edit') }}
            </a>
        @endcan

        @can($deleteGate)
            <form id="delete-{{ $row->id }}" action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
            <a class="dropdown-item" href="#" onclick="if(confirm('{{ trans(tenant()->id.'/global.areYouSure') }}')) document.getElementById('delete-{{ $row->id }}').submit()">
                <i style="margin-right:10px; " class="fa fa-trash"></i>
                {{ trans(tenant()->id.'/global.delete') }}
            </a>
        @endcan
        
        @can('dependent_create')
            <a class="dropdown-item" href="{{ route('admin.dependents.create', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-plus"></i>
                {{ trans(tenant()->id.'/cruds.dependent.fields.create_dependent') }}
            </a>
        @endcan

        @can('dependent_list')
            <a class="dropdown-item" href="{{ route('admin.dependents.index', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-eye fa-lg"></i>
                {{ trans(tenant()->id.'/cruds.dependent.fields.list_dependent') }}
            </a>
        @endcan
        
        @can(['member_access','member_create'])
            
            @if ($row->membership_category && $row->membership_type )
                <a class="dropdown-item" target="_blank" href="{{ route('admin.monthlyBilling.view-due-bill', $row->id) }}">
                    <i style="margin-right:10px; " class="fa fa-money fa-lg"></i>
                    {{ trans(tenant()->id.'/cruds.member.fields.monthly_bill') }}
                </a>
            @endif
        
        @endcan

    </div>
</div>



