@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.show') }} {{ trans('cruds.transaction.title') }}
        </h4>
    </div>

    <div class="card-body">
        <div class="form-group">
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.transactions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
            <table class="table table-borderless table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.transaction.fields.id') }}
                        </th>
                        <td>
                            {{ $transaction->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.transaction.fields.user') }}
                        </th>
                        <td>
                            {{ $transaction->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.transaction.fields.order') }}
                        </th>
                        <td>
                            {{ $transaction->order->status ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.transaction.fields.code') }}
                        </th>
                        <td>
                            {{ $transaction->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.transaction.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Transaction::TYPE_SELECT[$transaction->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.transaction.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Transaction::STATUS_SELECT[$transaction->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.transactions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>



@endsection