@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
            {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.item.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="form-group">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.items.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-borderless table-hover table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.item.fields.id') }}
                        </th>
                        <td>
                            {{ $item->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.item.fields.title') }}
                        </th>
                        <td>
                            {{ $item->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.item.fields.menu') }}
                        </th>
                        <td>
                            @foreach($item->menus as $key => $menu)
                                <span class="label label-info">{{ $menu->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.item.fields.menu_item_category') }}
                        </th>
                        <td>
                            {{ $item->menu_item_category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.item.fields.summary') }}
                        </th>
                        <td>
                            {{ $item->summary }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.item.fields.price') }}
                        </th>
                        <td>
                            {{ $item->price }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.items.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

{{-- <div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#item_order_items" role="tab" data-toggle="tab">
                {{ trans(tenant()->id.'/cruds.orderItem.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="item_order_items">
            @includeIf('admin.items.relationships.itemOrderItems', ['orderItems' => $item->itemOrderItems])
        </div>
    </div>
</div> --}}

@endsection
