@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.stockIssue.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.stock-issues.index') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssue.fields.id') }}
                        </th>
                        <td>
                            {{ $stockIssue->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssue.fields.issue_no') }}
                        </th>
                        <td>
                            {{ $stockIssue->issue_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssue.fields.issue_date') }}
                        </th>
                        <td>
                            {{ $stockIssue->issue_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssue.fields.section') }}
                        </th>
                        <td>
                            {{ $stockIssue->section->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssue.fields.store') }}
                        </th>
                        <td>
                            {{ $stockIssue->store->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssue.fields.employee') }}
                        </th>
                        <td>
                            {{ $stockIssue->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.stockIssue.fields.remarks') }}
                        </th>
                        <td>
                            {{ $stockIssue->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.stock-issues.index') }}">
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
            <a class="nav-link active" href="#stock_issue_stock_issue_items" role="tab" data-toggle="tab">
                {{ trans(tenant()->id.'/cruds.stockIssueItem.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel" id="stock_issue_stock_issue_items">
            @includeIf('admin.stockIssues.relationships.stockIssueStockIssueItems', ['stockIssueItems' => $stockIssue->stockIssueStockIssueItems])
        </div>
    </div>
</div>

@endsection
