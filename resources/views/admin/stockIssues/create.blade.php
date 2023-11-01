@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.create') }} {{ trans('cruds.stockIssue.title_singular') }}
        </h4>
    </div>

    <form method="POST" action="{{ route("admin.stock-issues.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body row">
            <div class="form-group col-md-4" x-data>
                <label class="required" for="issue_no">{{ trans('cruds.stockIssue.fields.issue_no') }}</label>
                <input x-mask="IS-No-99999" value="IS-No-{{ $last_id }}" readonly class="form-control {{ $errors->has('issue_no') ? 'is-invalid' : '' }}" type="text" name="issue_no" id="issue_no" value="{{ old('issue_no', '') }}" required>
                @if($errors->has('issue_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('issue_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssue.fields.issue_no_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="issue_date">{{ trans('cruds.stockIssue.fields.issue_date') }}</label>
                <input class="form-control date {{ $errors->has('issue_date') ? 'is-invalid' : '' }}" type="text" name="issue_date" id="issue_date" value="{{ old('issue_date') }}" required>
                @if($errors->has('issue_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('issue_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssue.fields.issue_date_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="section_id">{{ trans('cruds.stockIssue.fields.section') }}</label>
                <select class="form-control select2 {{ $errors->has('section') ? 'is-invalid' : '' }}" name="section_id" id="section_id" required>
                    @foreach($sections as $id => $entry)
                        <option value="{{ $id }}" {{ old('section_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('section'))
                    <div class="invalid-feedback">
                        {{ $errors->first('section') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssue.fields.section_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="store_id">{{ trans('cruds.stockIssue.fields.store') }}</label>
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
                <span class="help-block">{{ trans('cruds.stockIssue.fields.store_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="employee_id">{{ trans('cruds.stockIssue.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssue.fields.employee_helper') }}</span>
            </div>
            <div class="form-group col-md-12">
                <label for="remarks">{{ trans('cruds.stockIssue.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks">{{ old('remarks') }}</textarea>
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.stockIssue.fields.remarks_helper') }}</span>
            </div>
        </div>
        <div class="card-body row">

            <div class="col-md-12" x-data="handler()">
                <label for="photo">Stock Issue Items</label>
                <table class="table table-bordered align-items-center table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>Lot No</th>
                            <th>Stock Required</th>
                            <th>Stock Issued</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(field, index) in fields" :key="index">
                            <tr>
                                <td x-text="index + 1"></td>
                                <td>
                                    <select required x-model="field.item_id" x-on:change="getUnit(index)" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][item_id]`" id="item_id">
                                        @foreach($items as $id => $entry)
                                        <option value="{{ $id }}" {{ old('item_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" x-model="field.unit_id" :name="`items[${index}][unit_id]`">
                                    <input required x-model="field.unit" readonly class="form-control">
                                </td>
                                <td>
                                    <input class="form-control {{ $errors->has('lot_no') ? 'is-invalid' : '' }}" type="text" :name="`items[${index}][lot_no]`" id="lot_no" value="{{ old('lot_no', '') }}">
                                </td>
                                <td>
                                    <input class="form-control {{ $errors->has('stock_required') ? 'is-invalid' : '' }}" x-on:change="compareIssuedRequiredStocks(index)" type="number" x-model="field.stock_required" :name="`items[${index}][stock_required]`" id="stock_required"  step="1">
                                </td>
                                <td>
                                    <input class="form-control {{ $errors->has('issued_qty') ? 'is-invalid' : '' }}" x-on:change="compareIssuedRequiredStocks(index)" type="number" x-model="field.issued_qty" :name="`items[${index}][issued_qty]`" id="issued_qty" step="1">
                                </td>
                                <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Add Item Details</button></td>
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
    </form>
</div>



@endsection

<script>

    function handler() {

        return {
          fields: [
            {
                item_id:'',
                unit_id:'',
                lot_id:'',
                stock_required:'',
                issued_qty:'',
            }
            ],
            addNewField() {
              this.fields.push({
                item_id:'',
                unit_id:'',
                lot_id:'',
                stock_required:'',
                issued_qty:'',
               });
            },
            removeField(index) {
               this.fields.splice(index, 1);
            },
            async getUnit(index) {

                let data = await (await fetch("{{ route('admin.store-items.get_by_id') }}?item_id=" + this.fields[index].item_id)).json();
                this.fields[index].unit = data.unit.type;
                this.fields[index].unit_id = data.unit.id;

                // this.getLot(itemId);
            },
            async getLot(item_id) {

                let data = await (await fetch("{{ route('admin.store-items.get_lot_by_item') }}?item_id=" + item_id)).json();
                // this.fields[index].unit = data.unit.type;
                // this.fields[index].unit_id = data.unit.id;
            },
            calculateAmount(index) {
                if (this.fields[index].quantity) {
                    this.fields[index].total_amount = this.fields[index].quantity * this.fields[index].unit_rate;
                }

                this.grand_total = this.fields.reduce((accumulator, object) => {
                    return accumulator + object.total_amount;
                }, 0);
            },
            compareIssuedRequiredStocks(index) {

                let stock_required = this.fields[index].stock_required;
                let issued_stock = this.fields[index].issued_qty;

                // console.log("field value", this.fields[index]);

                if( issued_stock && stock_required < issued_stock) {
                    alert("Issued stock cannot be greater than required stock.");
                    // this.fields[index].stock_required = 0;
                    this.fields[index].issued_qty = 0;
                }
                // console.log("index value",index);
            }
        }
     };


    </script>
