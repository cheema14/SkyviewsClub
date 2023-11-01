@extends('layouts.admin')
@section('styles')
<style>
.dropDownItems:hover{
    background-color:#0D86FF;
}
</style>
@endsection
@section('content')
<form method="POST" action="{{ route("admin.good-receipts.store") }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h4>
            {{ trans('global.create') }} {{ trans('cruds.goodReceipt.title_singular') }}
            </h4>
        </div>

    
        <div class="card-body row">
            <div class="form-group col-md-4">
                <label class="required" for="gr_number">{{ trans('cruds.goodReceipt.fields.gr_number') }}</label>
                <input x-mask="GR-99999" value="GR-{{ $last_id }}" readonly class="form-control {{ $errors->has('gr_number') ? 'is-invalid' : '' }}" type="text" name="gr_number" id="gr_number" value="{{ old('gr_number', '') }}" required>
                @if($errors->has('gr_number'))
                <div class="invalid-feedback">
                    {{ $errors->first('gr_number') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.goodReceipt.fields.gr_number_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="store_id">{{ trans('cruds.goodReceipt.fields.store') }}</label>
                <select class="form-control select2 {{ $errors->has('store') ? 'is-invalid' : '' }}" name="store_id" id="store_id" required>
                    @foreach($stores as $id => $entry)
                    <option value="{{ $id }}" {{ old('store_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('store'))
                <div class="invalid-feedback">
                    {{ $errors->first('store') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.goodReceipt.fields.store_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="gr_date">{{ trans('cruds.goodReceipt.fields.gr_date') }}</label>
                <input class="form-control date {{ $errors->has('gr_date') ? 'is-invalid' : '' }}" type="text" name="gr_date" id="gr_date" value="{{ old('gr_date') }}" required>
                @if($errors->has('gr_date'))
                <div class="invalid-feedback">
                    {{ $errors->first('gr_date') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.goodReceipt.fields.gr_date_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="vendor_id">{{ trans('cruds.goodReceipt.fields.vendor') }}</label>
                <select class="form-control select2 {{ $errors->has('vendor') ? 'is-invalid' : '' }}" name="vendor_id" id="vendor_id" required>
                    @foreach($vendors as $id => $entry)
                    <option value="{{ $id }}" {{ old('vendor_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('vendor'))
                <div class="invalid-feedback">
                    {{ $errors->first('vendor') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.goodReceipt.fields.vendor_helper') }}</span>
            </div>
            {{-- <div class="form-group col-md-4">
                <label>{{ trans('cruds.goodReceipt.fields.pay_type') }}</label>
                <select class="form-control" name="pay_type" id="pay_type">
                    <option value disabled {{ old('pay_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\GoodReceipt::PAY_TYPE_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('pay_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

            </div> --}}
            <div class="form-group col-md-4">
                <label for="gr_bill_no">{{ trans('cruds.goodReceipt.fields.gr_bill_no') }}</label>
                <input class="form-control {{ $errors->has('gr_bill_no') ? 'is-invalid' : '' }}" type="text" name="gr_bill_no" value="{{ old('gr_bill_no') }}">

            </div>
            <div class="form-group col-md-12">
                <label for="remarks">{{ trans('cruds.goodReceipt.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks">{{ old('remarks') }}</textarea>
                @if($errors->has('remarks'))
                <div class="invalid-feedback">
                    {{ $errors->first('remarks') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.goodReceipt.fields.remarks_helper') }}</span>
            </div>
        </div>

        {{-- <div x-data="optionsHandler()">
            <input type="text" x-model="search" placeholder="Click to search..." @click="optionsVisible = !optionsVisible">
            <div x-show="optionsVisible" style="display:table !important;border:1px solid #ccc;">
                <template x-for="option in filteredOptions()">
                    <a @click.prevent="selected = option; optionsVisible = false;search=selected.name" x-text="option.name" style="display: block;border:1px solid #eee;padding:10px"></a>
                </template>
            </div>
        </div> --}}
        {{-- </div> --}}
       
        <div class="card-body row" x-data="handler()">

            <div class="col-md-12">
                <label for="photo">GR Item Detail</label>
                <p x-show="fields.showError" style="color: red;">Error: Purchase date is after expiry date.</p>
                <table class="table table-bordered align-items-center table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Unit Rate</th>
                            <th>Total Amount</th>
                            <th>Expiry Date</th>
                            {{-- <th>Purchase Date</th> --}}
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                         
                        <template x-for="(field, index) in fields" :key="index">
                            <tr>
                                <td x-text="index + 1"></td>
                                <td x-data="optionsHandler()">
                                    
                                    <input type="hidden" x-model="field.item_id" :name="`items[${index}][item_id]`">
                                    <input type="text" x-model="search" placeholder="Click to search..." @click="optionsVisible = !optionsVisible">
                                    
                                    <div x-show="optionsVisible" style="display:table !important;border:1px solid #ccc;">
                                        <template x-for="option in filteredOptions()">
                                            <a class="dropDownItems" @click.prevent="selected = option; optionsVisible = false;search=selected.name;field.item_id=selected.id;getUnit(index)" x-text="option.name" style="display:block;border:1px solid #eee;padding:10px"></a>
                                        </template>
                                    </div>
                                    
                                </td>
                                <td>
                                    <input type="hidden" x-model="field.unit_id" :name="`items[${index}][unit_id]`">
                                    <input required x-model="field.unit" readonly class="form-control">
                                </td>
                                <td>
                                    <input required x-on:keyup="calculateAmount(index)" x-mask:dynamic="$money($input, '.', '')" x-model="field.quantity" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" :name="`items[${index}][quantity]`" id="quantity" minlength="1" maxlength="4">
                                </td>
                                <td>
                                    <input required x-on:keyup="calculateAmount(index)" x-mask:dynamic="$money($input, '.', '')" x-model.fill="field.unit_rate" class="form-control {{ $errors->has('unit_rate') ? 'is-invalid' : '' }}" type="text" :name="`items[${index}][unit_rate]`" id="unit_rate" minlength="1" maxlength="9">
                                </td>
                                <td>
                                    <input readonly x-mask:dynamic="$money($input)" x-model="field.total_amount" class="form-control {{ $errors->has('total_amount') ? 'is-invalid' : '' }}" type="text" :name="`items[${index}][total_amount]`" id="total_amount" step="1">
                                </td>
                                <td>
                                    <input x-model="field.expiry_date" class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}" type="date" :name="`items[${index}][expiry_date]`" id="expiry_date">
                                </td>
                                {{-- <td>
                                    <input @change="compareDates(index)" x-model="field.purchase_date" class="form-control {{ $errors->has('purchase_date') ? 'is-invalid' : '' }}" type="date" :name="`items[${index}][purchase_date]`" id="purchase_date">
                                </td> --}}
                                <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                            </tr>
                        </template>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Add Item Details</button></td>
                        </tr>
                        <tr>
                            <th class="text-right"><b>Grand Total</b></th>
                            <td class="text-right"><strong><span x-text="grand_total"></strong></span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="form-group col-md-4">
                <button class="btn btn-success px-5" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </div>
    </div>
</form>

@endsection


@section('scripts')
<script>

    var itemsJson = @json($items);

    function formatDate(dateString) {
        return new Date(dateString).getTime();
    }

    function compareDates(expiryDate, purchaseDate) {
        console.log("expiryDate", expiryDate);
        console.log("purchaseDate", purchaseDate);
        // return formatDate(purchaseDate) > formatDate(expiryDate);
    }

    function handler() {

        function initializeSelect2(element) {
            $(element).select2();
        }

        return {

            grand_total: 0,
            temp: '1',
            fields: [{
                item_id: ''
                , unit: ''
                , unit_id: ''
                , quantity: ''
                , unit_rate: ''
                , total_amount: ''
                , expiry_date: ''
                , purchase_date: '',
                showError: false,

            }],

            addNewField() {
                this.fields.push({
                    item_id: ''
                    , unit: ''
                    , unit_id: ''
                    , quantity: ''
                    , unit_rate: ''
                    , total_amount: ''
                    , expiry_date: ''
                    , purchase_date: '',


                });

                this.$nextTick(() => {
                    const lastIndex = this.fields.length - 1;
                    const newSelectElement = document.querySelector(`select[name="items[${lastIndex}][item_id]"]`);
                    initializeSelect2(newSelectElement);
                });


            }
            , removeField(index) {
                this.fields.splice(index, 1);
                this.calculateGrandTotal();
            },
            async getUnit(index) {
                console.log("unit",index);
                let data = await (await fetch("{{ route('admin.store-items.get_by_id') }}?item_id=" + this.fields[index].item_id)).json();
                this.fields[index].unit = data.unit.type;
                this.fields[index].unit_id = data.unit.id;
            },
            calculateGrandTotal(){
                this.grand_total = this.fields.reduce((accumulator, object) => {
                    return accumulator + object.total_amount;
                }, 0);
            },
            calculateAmount(index) {
                if (this.fields[index].quantity) {
                    this.fields[index].total_amount = parseFloat(this.fields[index].quantity * this.fields[index].unit_rate) ;
                }
                this.calculateGrandTotal();
            },
            compareDates(index) {
                const field = this.fields[index];
                const purchaseDate = new Date(field.purchase_date);
                const expiryDate = new Date(field.expiry_date);

                if (expiryDate < purchaseDate) {
                    alert("Purchase date cannot be after expiry date");
                    this.fields[index].purchase_date = '';
                } else {
                    // nothing to do here
                }
            },

            'select2-item-changed'(index) {
                this.getUnit(index);
            },


        }
    };

    function optionsHandler(){
        return {
        optionsVisible: false,
        search: "",
        selected: {
            id: "",
            name: ""
        },
        options:itemsJson,
        filteredOptions() {
            return this.options.filter((option) => {
                return option.name.toLowerCase().includes(this.search.toLowerCase());
            });
        }
    };
    }

</script>
@endsection