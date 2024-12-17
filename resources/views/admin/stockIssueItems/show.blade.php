@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.stockIssueItem.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.stock-issue-items.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.id') }}
                        </th>
                        <td>
                            {{ $stockIssueItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.item') }}
                        </th>
                        <td>
                            {{ $stockIssueItem->item->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.unit') }}
                        </th>
                        <td>
                            {{ $stockIssueItem->unit->type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.lot_no') }}
                        </th>
                        <td>
                            {{ $stockIssueItem->lot_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.stock_required') }}
                        </th>
                        <td>
                            {{ $stockIssueItem->stock_required }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.issued_qty') }}
                        </th>
                        <td>
                            {{ $stockIssueItem->issued_qty }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssueItem.fields.stock_issue') }}
                        </th>
                        <td>
                            {{ $stockIssueItem->stock_issue->issue_no ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.stock-issue-items.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>



@endsection