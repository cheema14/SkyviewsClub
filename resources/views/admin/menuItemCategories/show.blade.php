@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.show') }} {{ trans('cruds.menuItemCategory.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.menu-item-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.menuItemCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $menuItemCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.menuItemCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $menuItemCategory->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.menu-item-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.relatedData') }}
        </h4>
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#menu_item_category_items" role="tab" data-toggle="tab">
                {{ trans('cruds.item.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="menu_item_category_items">
            @includeIf('admin.menuItemCategories.relationships.menuItemCategoryItems', ['items' => $menuItemCategory->menuItemCategoryItems])
        </div>
    </div>
</div>

@endsection
