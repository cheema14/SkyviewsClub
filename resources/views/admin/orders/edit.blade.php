@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.edit') }} {{ trans('cruds.order.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.update", [$order->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group col-md-4">
                <label class="required" for="member_id">{{ trans('cruds.order.fields.member') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="member_id" id="member_id" required>
                    @foreach($members as $id => $member)
                        <option value="{{ $member->id }}" {{ (old('member_id') ? old('member_id') : $order->member->id ?? '') == $member->id ? 'selected' : '' }}>{{ $member->membership_no }} - {{ $member->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.member_helper') }}</span>
            </div>

            {{-- <div class="form-group col-md-4">
                <label class="required" for="menu">Menus</label>
                <select class="form-control select2 {{ $errors->has('menu_id') ? 'is-invalid' : '' }}" name="menu_id" id="menu_id" required>
                    @foreach($menus as $id => $entry)
                        <option value="{{ $id }}" {{ (old('menu_id') ? old('menu_id') : $order->menu_id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('menu') }}
                    </div>
                @endif
                <span class="help-block"> </span>
            </div> --}}

            <div class="form-group col-md-4">
                <label class="required" for="menu">Table Top</label>
                <select class="form-control select2 {{ $errors->has('table_top_id') ? 'is-invalid' : '' }}" name="table_top_id" id="table_top_id" required>
                    @foreach($tableTops as $id => $entry)
                        <option value="{{ $id }}" {{ (old('table_top_id') ? old('table_top_id') : $order->table_top_id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('table_top_id') }}
                    </div>
                @endif
                <span class="help-block"> </span>
            </div>

            <div class="form-group col-md-4">
                <label class="required">{{ trans('cruds.order.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Order::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $order->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.status_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label class="required" for="no_of_guests">No of guests</label>
                <input class="form-control {{ $errors->has('no_of_guests') ? 'is-invalid' : '' }}" type="number" name="no_of_guests" id="no_of_guests" value="{{ old('no_of_guests', $order->no_of_guests) }}">
                @if($errors->has('no_of_guests'))
                    <div class="invalid-feedback">
                        {{ $errors->first('no_of_guests') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>

            {{-- <div class="form-group col-md-4">
                <label class="required" for="name">Floor</label>
                <select class="form-control select2 {{ $errors->has('floor') ? 'is-invalid' : '' }}" name="floor" id="floor">
                    <option value="" selected disabled>Select Floor</option>
                    @foreach($printers as $id => $printer)
                        <option value="{{ $printer['id'] }}" {{ $order->floor == $printer['id'] ? 'selected' : '' }}>{{ $printer['name'] }}</option>
                    @endforeach
                </select>
                <span class="help-block"></span>
            </div> --}}


            {{-- <div class="form-group col-md-4">
                <label for="item_discount">{{ trans('cruds.order.fields.item_discount') }}</label>
                <input class="form-control {{ $errors->has('item_discount') ? 'is-invalid' : '' }}" type="number" name="item_discount" id="item_discount" value="{{ old('item_discount', $order->item_discount) }}" step="0.01">
                @if($errors->has('item_discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_discount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.item_discount_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="sub_total">{{ trans('cruds.order.fields.sub_total') }}</label>
                <input class="form-control {{ $errors->has('sub_total') ? 'is-invalid' : '' }}" type="number" name="sub_total" id="sub_total" value="{{ old('sub_total', $order->sub_total) }}" step="0.01">
                @if($errors->has('sub_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sub_total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.sub_total_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="tax">{{ trans('cruds.order.fields.tax') }}</label>
                <input class="form-control {{ $errors->has('tax') ? 'is-invalid' : '' }}" type="number" name="tax" id="tax" value="{{ old('tax', $order->tax) }}" step="0.01">
                @if($errors->has('tax'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tax') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.tax_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="total">{{ trans('cruds.order.fields.total') }}</label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" name="total" id="total" value="{{ old('total', $order->total) }}" step="0.01">
                @if($errors->has('total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.total_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="promo">{{ trans('cruds.order.fields.promo') }}</label>
                <input class="form-control {{ $errors->has('promo') ? 'is-invalid' : '' }}" type="text" name="promo" id="promo" value="{{ old('promo', $order->promo) }}">
                @if($errors->has('promo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('promo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.promo_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="discount">{{ trans('cruds.order.fields.discount') }}</label>
                <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', $order->discount) }}" step="0.01">
                @if($errors->has('discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.discount_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="grand_total">{{ trans('cruds.order.fields.grand_total') }}</label>
                <input class="form-control {{ $errors->has('grand_total') ? 'is-invalid' : '' }}" type="number" name="grand_total" id="grand_total" value="{{ old('grand_total', $order->grand_total) }}" step="0.01">
                @if($errors->has('grand_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('grand_total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.grand_total_helper') }}</span>
            </div> --}}
            {{-- <div class="form-group col-md-4">
                <label class="required" for="items">{{ trans('cruds.order.fields.item') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('items') ? 'is-invalid' : '' }}" name="items[]" id="items" multiple required>
                    @foreach($items as $id => $item)
                        <option value="{{ $id }}" {{ (in_array($id, old('items', [])) || $order->items->contains($id)) ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
                @if($errors->has('items'))
                    <div class="invalid-feedback">
                        {{ $errors->first('items') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.item_helper') }}</span>
            </div> --}}

            <div class="card-body row" x-data="handler()">

                <div class="col-md-6">
                    <label for="photo">Select Items</label>
                    <table class="table table-bordered align-items-center table-sm">
                        <thead >
                            <tr>
                                <th>#</th>
                                <th>Menu</th>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(field, index) in fields" :key="index">
                                <tr>
                                    <td x-text="index + 1"></td>
                                    <td>
                                        <select required x-model="field.pivot.menu_id"  class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][menu_id]`" id="menu_id">
                                            @foreach($menus as $id => $entry)
                                                <option value="{{ $id }}" x-bind:selected="field.pivot.menu_id == '{{ $id }}' ? true : false">{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select required x-model="field.item_id" x-on:change="getPrice(index)" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][item_id]`" id="item_id">
                                            <option>Please select</option>
                                            @foreach($items as $id => $entry)
                                            <option
                                                value="{{ $id }}" x-bind:selected="field.id == '{{ $id }}' ? true : false">{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" x-model="field.pivot.price" :name="`items[${index}][price]`">
                                        <input required x-model="field.pivot.price" readonly class="form-control">
                                    </td>
                                    <td>
                                        <input
                                            x-model="field.pivot.quantity"
                                            class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" :name="`items[${index}][quantity]`" id="quantity" >
                                    </td>

                                    <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                </tr>
                            </template>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Add Items</button></td>
                            </tr>

                        </tfoot>
                    </table>
                </div>

            </div>

            <div class="form-group col-md-4">
                <button class="btn btn-info px-5" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
    function handler() {

        return {
            fields: @json($order->items)
            , addNewField() {
                this.fields.push({
                    item_id: '',
                    menu_category_id:'',
                    pivot:{
                        price : '',
                        quantity : '',
                        menu_id:'',
                    }
                });
            }
            , removeField(index) {
                this.fields.splice(index, 1);
            },

            async getPrice(index) {

                let data = await (await fetch("{{ route('admin.items.getById') }}?item_id=" + this.fields[index].item_id)).json();
                this.fields[index].pivot.price = data.item.price;
            },
            async getItem(index) {
                // console.log("this.fields",this.fields[index]);
                let data = await (await fetch("{{ route('admin.items.getItemByMenu') }}?menu_id=" + this.fields[index].pivot.menu_id)).json();
                this.fields[index].pivot.price = data.item.price;
            }


        }
    };

</script>
