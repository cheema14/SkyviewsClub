@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <h4>
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.menu.title') }}
    </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.menus.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-borderless table-hover table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.menu.fields.id') }}
                        </th>
                        <td>
                            {{ $menu->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.menu.fields.title') }}
                        </th>
                        <td>
                            {{ $menu->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.menu.fields.summary') }}
                        </th>
                        <td>
                            {{ $menu->summary }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.menus.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.relatedData') }}
        </h4>
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#menu_items" role="tab" data-toggle="tab">
                {{ trans(tenant()->id.'/cruds.item.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="menu_items">
            @includeIf('admin.menus.relationships.menuItems', ['items' => $menu->menuItems])
        </div>
    </div>
</div>

@endsection
