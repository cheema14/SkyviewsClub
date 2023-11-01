<div>

    <div class="card">
        <div class="card-header">
            <h4>
                {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
            </h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.orders.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.order.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                        @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="member_id">{{ trans('cruds.order.fields.member') }}</label>
                    <select class="form-control select2 {{ $errors->has('member') ? 'is-invalid' : '' }}" name="member_id" id="member_id" required>
                        @foreach($members as $id => $entry)
                        <option value="{{ $id }}" {{ old('member_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('member'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.member_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.order.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Order::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="item_discount">{{ trans('cruds.order.fields.item_discount') }}</label>
                    <input class="form-control {{ $errors->has('item_discount') ? 'is-invalid' : '' }}" type="number" name="item_discount" id="item_discount" value="{{ old('item_discount', '') }}" step="0.01">
                    @if($errors->has('item_discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_discount') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.item_discount_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="sub_total">{{ trans('cruds.order.fields.sub_total') }}</label>
                    <input class="form-control {{ $errors->has('sub_total') ? 'is-invalid' : '' }}" type="number" name="sub_total" id="sub_total" value="{{ old('sub_total', '') }}" step="0.01">
                    @if($errors->has('sub_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sub_total') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.sub_total_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="tax">{{ trans('cruds.order.fields.tax') }}</label>
                    <input class="form-control {{ $errors->has('tax') ? 'is-invalid' : '' }}" type="number" name="tax" id="tax" value="{{ old('tax', '') }}" step="0.01">
                    @if($errors->has('tax'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tax') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.tax_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="total">{{ trans('cruds.order.fields.total') }}</label>
                    <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" name="total" id="total" value="{{ old('total', '') }}" step="0.01">
                    @if($errors->has('total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.total_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="promo">{{ trans('cruds.order.fields.promo') }}</label>
                    <input class="form-control {{ $errors->has('promo') ? 'is-invalid' : '' }}" type="text" name="promo" id="promo" value="{{ old('promo', '') }}">
                    @if($errors->has('promo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('promo') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.promo_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="discount">{{ trans('cruds.order.fields.discount') }}</label>
                    <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', '') }}" step="0.01">
                    @if($errors->has('discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.discount_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="grand_total">{{ trans('cruds.order.fields.grand_total') }}</label>
                    <input class="form-control {{ $errors->has('grand_total') ? 'is-invalid' : '' }}" type="number" name="grand_total" id="grand_total" value="{{ old('grand_total', '') }}" step="0.01">
                    @if($errors->has('grand_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('grand_total') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.grand_total_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="items">{{ trans('cruds.order.fields.item') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('items') ? 'is-invalid' : '' }}" name="items[]" id="items" multiple required>
                        @foreach($items as $id => $item)
                        <option value="{{ $id }}" {{ in_array($id, old('items', [])) ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('items'))
                    <div class="invalid-feedback">
                        {{ $errors->first('items') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.item_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-success px-5" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
