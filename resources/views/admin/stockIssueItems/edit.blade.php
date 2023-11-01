@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.edit') }} {{ trans('cruds.stockIssueItem.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.stock-issue-items.update", [$stockIssueItem->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="item_id">{{ trans('cruds.stockIssueItem.fields.item') }}</label>
                <select class="form-control select2 {{ $errors->has('item') ? 'is-invalid' : '' }}" name="item_id" id="item_id" required>
                    @foreach($items as $id => $entry)
                        <option value="{{ $id }}" {{ (old('item_id') ? old('item_id') : $stockIssueItem->item->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('item'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssueItem.fields.item_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit_id">{{ trans('cruds.stockIssueItem.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id" required>
                    @foreach($units as $id => $entry)
                        <option value="{{ $id }}" {{ (old('unit_id') ? old('unit_id') : $stockIssueItem->unit->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('unit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssueItem.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="lot_no">{{ trans('cruds.stockIssueItem.fields.lot_no') }}</label>
                <input class="form-control {{ $errors->has('lot_no') ? 'is-invalid' : '' }}" type="text" name="lot_no" id="lot_no" value="{{ old('lot_no', $stockIssueItem->lot_no) }}" required>
                @if($errors->has('lot_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lot_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssueItem.fields.lot_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="stock_required">{{ trans('cruds.stockIssueItem.fields.stock_required') }}</label>
                <input class="form-control {{ $errors->has('stock_required') ? 'is-invalid' : '' }}" type="number" name="stock_required" id="stock_required" value="{{ old('stock_required', $stockIssueItem->stock_required) }}" step="1" required>
                @if($errors->has('stock_required'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stock_required') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssueItem.fields.stock_required_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="issued_qty">{{ trans('cruds.stockIssueItem.fields.issued_qty') }}</label>
                <input class="form-control {{ $errors->has('issued_qty') ? 'is-invalid' : '' }}" type="number" name="issued_qty" id="issued_qty" value="{{ old('issued_qty', $stockIssueItem->issued_qty) }}" step="1" required>
                @if($errors->has('issued_qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('issued_qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssueItem.fields.issued_qty_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="stock_issue_id">{{ trans('cruds.stockIssueItem.fields.stock_issue') }}</label>
                <select class="form-control select2 {{ $errors->has('stock_issue') ? 'is-invalid' : '' }}" name="stock_issue_id" id="stock_issue_id" required>
                    <option value="" disabled selected>Select Issue No</option>
                    @foreach($stock_issues as $issue)
                        <option value="{{ $issue->id }}" {{ old('stock_issue_id') == $issue->id ? 'selected' : '' }}>{{ $issue->issue_no }}</option>
                    @endforeach
                </select>
                @if($errors->has('stock_issue'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stock_issue') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssueItem.fields.stock_issue_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-info px-5" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
