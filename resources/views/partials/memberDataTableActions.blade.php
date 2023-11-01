{{-- @can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan

@can('dependent_create')
    <a class="btn btn-xs btn-success" href="{{ route('admin.dependents.create', $row->id) }}">
        {{ trans('cruds.dependent.fields.create_dependent') }}
    </a>
@endcan

@can('dependent_list')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.dependents.index', $row->id) }}">
        {{ trans('cruds.dependent.fields.list_dependent') }}
    </a>
@endcan

<a class="btn btn-xs btn-primary" href="{{ route('admin.view-monthly-bill', $row->id) }}">
    {{ trans('cruds.member.fields.monthly_bill') }}
</a> --}}

<div class="dropdown text-center">
    <a class="dropdown-button" id="dropdown-menu-{{ $row->id }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-v"></i>
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdown-menu-{{ $row->id }}">
        @can($viewGate)
            <a class="dropdown-item" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-eye fa-lg"></i>
                {{ trans('global.view') }}
            </a>
        @endcan

        @can($editGate)
            <a class="dropdown-item" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-edit"></i>
                {{ trans('global.edit') }}
            </a>
        @endcan

        @can($deleteGate)
            <form id="delete-{{ $row->id }}" action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
            <a class="dropdown-item" href="#" onclick="if(confirm('{{ trans('global.areYouSure') }}')) document.getElementById('delete-{{ $row->id }}').submit()">
                <i style="margin-right:10px; " class="fa fa-trash"></i>
                {{ trans('global.delete') }}
            </a>
        @endcan
        @can('dependent_create')
            <a class="dropdown-item" href="{{ route('admin.dependents.create', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-plus"></i>
                {{ trans('cruds.dependent.fields.create_dependent') }}
            </a>
        @endcan

        @can('dependent_list')
            <a class="dropdown-item" href="{{ route('admin.dependents.index', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-eye fa-lg"></i>
                {{ trans('cruds.dependent.fields.list_dependent') }}
            </a>
        @endcan

        @if ($row->membership_category && $row->membership_type )
            <a class="dropdown-item" href="{{ route('admin.view-monthly-bill', $row->id) }}">
                <i style="margin-right:10px; " class="fa fa-money fa-lg"></i>
                {{ trans('cruds.member.fields.monthly_bill') }}
            </a>
        @endif

    </div>
</div>



