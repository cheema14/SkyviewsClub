@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header">
        <h4>
            {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
        </h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group col-md-4 ">
                <label class="required" for="member_id">{{ trans('cruds.order.fields.member') }}</label>
                <select class="form-control select2 {{ $errors->has('member') ? 'is-invalid' : '' }}" name="member_id" id="member_id" required>
                    <option value="">Please select</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->membership_no }}-{{ $member->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('member'))
                <div class="invalid-feedback">
                    {{ $errors->first('member') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.member_helper') }}</span>
            </div>

            {{-- <div class="form-group col-md-4">
                <label class="required" for="user_id">Menu</label>
                <select class="form-control select2 {{ $errors->has('menu') ? 'is-invalid' : '' }}" name="menu_id" id="menu_id" required>
                    @foreach($menus as $id => $entry)
                    <option value="{{ $id }}" {{ old('menu_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('menu'))
                <div class="invalid-feedback">
                    {{ $errors->first('user') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div> --}}


            {{-- <div class="form-group col-md-4">
                <label class="required" for="user_id">Category</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                    @foreach($categories as $id => $entry)
                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                <div class="invalid-feedback">
                    {{ $errors->first('category') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div> --}}

            <div class="form-group col-md-4">
                <label class="required" for="user_id">Table Top</label>
                <select class="form-control select2 {{ $errors->has('table') ? 'is-invalid' : '' }}" name="table_top_id" id="table_top_id" required>
                    @foreach($tableTops as $id => $entry)
                    <option value="{{ $id }}" {{ old('table_top_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('table'))
                <div class="invalid-feedback">
                    {{ $errors->first('table') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div>

            <div class="form-group col-md-4">
                <label class="required" for="name">No of Guests</label>
                <input class="form-control {{ $errors->has('no_of_guests') ? 'is-invalid' : '' }}" type="number" name="no_of_guests" id="no_of_guests" value="{{ old('no_of_guests', '') }}" required>
                @if($errors->has('no_of_guests'))
                <div class="invalid-feedback">
                    {{ $errors->first('no_of_guests') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div>

            {{-- <div class="form-group col-md-4">
                <label class="required" for="name">Floor</label>
                <select class="form-control select2 {{ $errors->has('floor') ? 'is-invalid' : '' }}" name="floor" id="floor" required>
                    <option value="" selected disabled>Select Floor</option>
                    @foreach($printers as $id => $printer)
                        <option value="{{ $printer['id'] }}" {{ old('floor') == $id ? 'selected' : '' }}>{{ $printer['name'] }}</option>
                    @endforeach
                </select>
                <span class="help-block"></span>
            </div> --}}


            {{-- <div class="form-group col-md-4">
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
                                            <option value="{{ $id }}" {{ old('item_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" x-model="field.price" :name="`items[${index}][price]`">
                                        <input required x-model="field.price" readonly class="form-control">
                                    </td>
                                    <td>
                                        <input required x-model="field.quantity" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" :name="`items[${index}][quantity]`" id="quantity" >
                                    </td>

                                    <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                </tr>
                            </template>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Add Item</button></td>
                            </tr>

                        </tfoot>
                    </table>
                </div>

            </div>

            {{-- <div class="form-group col-md-4">
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
    </div> --}}

    <div class="form-group col-md-4">
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


    <div class="form-group col-md-4">
        <button class="btn btn-success px-5" type="submit">
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
            fields: [{
                item_id: ''
                , price: ''
                , quantity: ''
            }]
            , addNewField() {
                this.fields.push({
                    item_id: ''
                    , price: ''
                    , quantity: ''
                });
            }
            , removeField(index) {
                this.fields.splice(index, 1);
            },

            async getPrice(index) {

                let data = await (await fetch("{{ route('admin.items.getById') }}?item_id=" + this.fields[index].item_id)).json();
                this.fields[index].price = data.item.price;
            },

            calculateAmount(index) {
                if (this.fields[index].quantity) {
                    this.fields[index].total_amount = this.fields[index].quantity * this.fields[index].unit_rate;
                }

                this.grand_total = this.fields.reduce((accumulator, object) => {
                    return accumulator + object.total_amount;
                }, 0);
            }


        }
    };

</script>
