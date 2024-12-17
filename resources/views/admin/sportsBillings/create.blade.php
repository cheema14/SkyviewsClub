@extends('layouts.'.tenant()->id.'/admin')
@section('content')
@section('styles')
<style>
    .btn-paf{
        background:#acdae6 !important;
    }
    .original-background-important{
        background-color: #d8dbe0 !important;
    }

    .modal-content{
      border-radius: 10px;
    }
    .modal-header{
      background: #06c1f0;
      color: #fff;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
    .modal-header .close {
      color: #fff;
      opacity: 1;
    }
    .modal-title{
      line-height: 1;
    }
    .modal-body{
      padding: 40px;
    }
    .modal-footer{
      text-align: center;
      border-top-color: transparent;
    }
    .modal-footer button{
      max-width: 150px;
      width: 100%;
    }
    
</style>
@endsection



<div class="card" x-data="handler()">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.sportsBilling.title_singular') }}
        <button x-show="showDependents" x-model="showDependents" data-toggle="modal" data-target="#showMemberInfo" style="float:right" class="btn btn-success">{{ trans(tenant()->id.'/cruds.sportsBilling.showDependents') }} </button>
    </div>

    <form method="POST" action="{{ route("admin.sports-billings.store") }}" enctype="multipart/form-data">
    @csrf
        <div class="card-body row" x-data="{ membershipNo: '', memberName: '', nonMemberName: '' }">
            <div class="form-group col-md-4" x-show="!nonMemberName">
                <label class="required" for="membership_no">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.membership_no') }}</label>
                <input class="form-control {{ $errors->has('membership_no') ? 'is-invalid' : '' }}" x-model="membershipNo" x-on:blur="getMemberInfo($event)" type="text" name="membership_no" id="membership_no" value="{{ old('membership_no', '') }}">
                <p id="membership_no_error" style="color:red;display:none;">Invalid Membership no</p>
                @if($errors->has('membership_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('membership_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.member.fields.membership_no_helper') }}</span>
            </div>
            <div class="form-group col-md-4" x-show="!nonMemberName">
                <label for="member_name">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.member_name') }}</label>
                <input readonly class="form-control {{ $errors->has('member_name') ? 'is-invalid' : '' }}" x-model="memberName" type="text" name="member_name" id="member_name">
                @if($errors->has('member_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.member_name_helper') }}</span>
            </div>
            <div class="form-group col-md-4" x-show="!nonMemberName">
                <label for="membership_status_label">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.membership_status') }}</label>
                <input readonly class="form-control {{ $errors->has('membership_status') ? 'is-invalid' : '' }}" x-model="memberStatus" type="text" name="membership_status" id="membership_status">
                @if($errors->has('membership_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('membership_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.member_name_helper') }}</span>
            </div>
            <div class="form-group col-md-4" x-show="!membershipNo">
                <label for="non_member_name">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.non_member_name') }}</label>
                <input class="form-control {{ $errors->has('non_member_name') ? 'is-invalid' : '' }}" x-model="nonMemberName" type="text" name="non_member_name" id="non_member_name" value="{{ old('non_member_name', '') }}">
                @if($errors->has('non_member_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('non_member_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.non_member_name_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="bill_date">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_date') }}</label>
                <input disabled class="form-control date {{ $errors->has('bill_date') ? 'is-invalid' : '' }}" type="text" name="bill_date" id="bill_date" value="{{ old('bill_date') }}" required>
                <input type="hidden" id="bill_date_post" name="bill_date" >
                @if($errors->has('bill_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bill_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_date_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="bill_number">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_number') }}</label>
                <input readonly class="form-control {{ $errors->has('bill_number') ? 'is-invalid' : '' }}" type="text" name="bill_number" id="bill_number" value="{{ $new_billing_id }}">
                @if($errors->has('bill_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bill_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_number_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="remarks">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}">
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="ref_club">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.ref_club') }}</label>
                <input class="form-control {{ $errors->has('ref_club') ? 'is-invalid' : '' }}" type="text" name="ref_club" id="ref_club" value="{{ old('ref_club', '') }}">
                @if($errors->has('ref_club'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ref_club') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.ref_club_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="club_id_ref">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.club_id_ref') }}</label>
                <input class="form-control {{ $errors->has('club_id_ref') ? 'is-invalid' : '' }}" type="text" name="club_id_ref" id="club_id_ref" value="{{ old('club_id_ref', '') }}">
                @if($errors->has('club_id_ref'))
                    <div class="invalid-feedback">
                        {{ $errors->first('club_id_ref') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.club_id_ref_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="tee_off">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.tee_off') }}</label>
                <input class="form-control {{ $errors->has('tee_off') ? 'is-invalid' : '' }}" type="text" name="tee_off" id="tee_off" value="{{ old('tee_off', '') }}">
                @if($errors->has('tee_off'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tee_off') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.tee_off_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="holes">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.holes') }}</label>
                <input class="form-control {{ $errors->has('holes') ? 'is-invalid' : '' }}" type="text" name="holes" id="holes" value="{{ old('holes', '') }}">
                @if($errors->has('holes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('holes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.holes_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="caddy">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.caddy') }}</label>
                <input class="form-control {{ $errors->has('caddy') ? 'is-invalid' : '' }}" type="text" name="caddy" id="caddy" value="{{ old('caddy', '') }}">
                @if($errors->has('caddy'))
                    <div class="invalid-feedback">
                        {{ $errors->first('caddy') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.caddy_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="temp_mbr">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_mbr') }}</label>
                <input class="form-control {{ $errors->has('temp_mbr') ? 'is-invalid' : '' }}" type="text" name="temp_mbr" id="temp_mbr" value="{{ old('temp_mbr', '') }}">
                @if($errors->has('temp_mbr'))
                    <div class="invalid-feedback">
                        {{ $errors->first('temp_mbr') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_mbr_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="temp_caddy">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_caddy') }}</label>
                <input class="form-control {{ $errors->has('temp_caddy') ? 'is-invalid' : '' }}" type="text" name="temp_caddy" id="temp_caddy" value="{{ old('temp_caddy', '') }}">
                @if($errors->has('temp_caddy'))
                    <div class="invalid-feedback">
                        {{ $errors->first('temp_caddy') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_caddy_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label>{{ trans(tenant()->id.'/cruds.sportsBilling.fields.pay_mode') }}</label>
                <select x-on:change="showBankCharges($event)" x-model="payMode" class="form-control {{ $errors->has('pay_mode') ? 'is-invalid' : '' }}" name="pay_mode" id="pay_mode">
                    <option value disabled {{ old('pay_mode', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\SportsBilling::PAY_MODE_SELECT as $key => $label)
                        <option x-show="nonMemberName === '' || ['credit'].indexOf('{{ $key }}') === -1" value="{{ $key }}" value="{{ $key }}" {{ old('pay_mode', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                @if($errors->has('pay_mode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pay_mode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.pay_mode_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label>{{ trans(tenant()->id.'/cruds.sportsBilling.fields.division') }}</label>
                <select required name="item_division_id" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" id="item_division" x-on:change="getDivision($event)">
                    @foreach($divisions as $id => $entry)
                    <option value="{{ $id }}" x-bind:selected="shared.division == '{{ $id }}' ? true : false">{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('division'))
                    <div class="invalid-feedback">
                        {{ $errors->first('division') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.division_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label>{{ trans(tenant()->id.'/cruds.sportsBilling.fields.item_type') }}</label>
                <select required  x-on:change="getClass($event)" name="item_type_id" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" id="item_type" x-model="shared.itemType" >
                        <option value="" disabled selected>Select an option</option>
                            <template x-for="type in fields.types">
                                <option x-text="type.item_type"  x-bind:value="type.id"></option>
                            </template>
                </select>
                @if($errors->has('item_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.item_type_helper') }}</span>
            </div>

            <div class="form-group col-md-4">
                <label>{{ trans(tenant()->id.'/cruds.sportsBilling.fields.discount') }}</label>
                <input x-model="discountPercent" x-on:change="calculateDiscountOnChange($event)" class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', '') }}" step="0.01">
            </div>
            
            
        </div>
        <div class="card-body row">

            <div class="col-md-12">
                <label for="photo">Billing Items</label>
                <table class="table table-bordered align-items-center table-md">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            {{-- <th>Item Division</th>
                            <th>Item Type</th> --}}
                            <th>Item Class</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            {{-- <th>Item Description</th> --}}
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(field, index) in fields" :key="index">
                            <tr>
                                <td x-text="index + 1"></td>
                                {{-- <td>
                                    <select required x-model="field.item_division" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][billing_division_id]`" id="item_division" x-on:change="getDivision(index)">
                                        @foreach($divisions as $id => $entry)
                                        <option value="{{ $id }}" {{ old('item_division') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                </td> --}}
                                {{-- <td>
                                    <select required x-model="field.item_type" x-on:change="getClass(index)" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][billing_item_type_id]`" id="item_type">
                                        <option value="" disabled selected>Select an option</option>
                                            <template x-for="type in field.types">
                                                <option x-text="type.item_type" x-bind:value="type.id"></option>
                                            </template>
                                    </select>
                                </td> --}}
                                <td>
                                    {{-- Item Class --}}
                                    <select required x-model="field.item_class" x-on:change="getItems(index)" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][billing_item_class_id]`" id="item_class">
                                            <option value="" disabled selected>Select Type</option>
                                            <template x-for="type in field.classes">
                                                <option x-text="type.item_class" x-bind:value="type.id"></option>
                                            </template>
                                    </select>
                                </td>
                                <td>
                                    {{-- Item Name --}}
                                    <select required x-model="field.item_name" x-on:change="getItemDetails(index)" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][billing_item_name_id]`" id="item_name">
                                        <option value="" disabled selected>Select Type</option>
                                        <template x-for="type in field.items">
                                            <option x-text="type.item_name" x-bind:value="type.id"></option>
                                        </template>
                                </select>
                                </td>
                                <td>
                                    {{-- Item Code --}}
                                    {{-- <input type="hidden" x-model="field.item_id" :name="`items[${index}][item_id]`"> --}}
                                    <input required x-model="field.item_code" readonly :name="`items[${index}][billing_issue_item_id]`" class="form-control">
                                </td>
                                {{-- <td>
                                    <input required x-model="field.item_description" :name="`items[${index}][billing_item_description]`" class="form-control">
                                </td> --}}
                                <td>
                                    {{-- Quantity --}}
                                    <input required x-on:change="calculateAmount(index)" x-model="field.quantity" :name="`items[${index}][quantity]`" type="number" class="form-control" min="0" max="1000" @input="limitQuantityInput($event, index)">
                                </td>
                                <td>
                                    {{-- Rate --}}
                                    <input required x-model="field.rate" readonly :name="`items[${index}][rate]`" class="form-control">
                                </td>
                                <td>
                                    {{-- Amount --}}
                                    <input required x-model="field.amount" readonly :name="`items[${index}][amount]`" class="form-control">
                                </td>
                                <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"></td>
                            <td colspan="2">Gross Total:</td>
                            <td><input type="number" readonly name="gross_total" id="gross_total" class="form-control"></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                            <td colspan="2">Total Payable:</td>
                            <td><input type="number" readonly name="total_payable" id="total_payable" class="form-control"></td>
                        </tr>
                        <tr id="bankCharges" style="display:none;">
                            <td colspan="8"></td>
                            <td colspan="2">Bank Charges:</td>
                            <td><input class="form-control {{ $errors->has('bank_charges') ? 'is-invalid' : '' }}" readonly type="number" name="bank_charges" id="bank_charges" value="{{ old('bank_charges', '') }}" step="0.01"></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                            <td colspan="2">Discount Amount:</td>
                            <td><input x-model="displayDiscountAmount" class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="text" name="displayDiscountAmount" id="displayDiscountAmount" value="" readonly></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                            <td colspan="2">Net Payable:</td>
                            <td><input type="number" readonly name="net_pay" id="net_payable" class="form-control"></td>
                        </tr>
                        <tr>
                            <td colspan="12" class="text-right"><button type="button" class="btn btn-info" @click="addNewField()">+ Add Item</button></td>
                        </tr>
                        
                    </tfoot>
                </table>
            </div>

            <div class="form-group col-md-4">
                <button class="btn btn-danger" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </div>
            
    </form>
</div>

<div id="showMemberInfo" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Member Information</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button> <br />
        </div>
        <div class="modal-body text-center">
             <img class="memberPhoto" src="" />
             <p class="memberStatus"></p>
        </div>
        <div class="modal-footer text-center">
          <button type="button"  class="btn btn-paf btn-md" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    // Get the current date in the format YYYY-MM-DD
    const currentDate = new Date().toISOString().split('T')[0];

    // Set the value of the 'bill_date' input to the current date
    document.getElementById('bill_date_post').value = currentDate;
    function handler() {

        return {
            payMode:'',
            discountPercent:'0',
            displayDiscountAmount:'0',
            bank_charges_percentage:2.37,
            memberName:'',
            memberStatus:'',
            showDependents:false,
            globalIndex:0,
            shared: {
                division: '',
                itemType: '',
            },
            fields: [{
                item_division:'',
                item_type:'',
                item_class:'',
                item_name:'',
                item_description:'',
                quantity:'',
                rate:'',
                amount:'',
                gross_total:'',
                total_payable:'',
                net_payable:'',
                types:[],
                classes:[],
                items:[],
                itemDetails:[],
                showDropdown:false,
                showClassDropdown:false,
                showItemDropdown:false,
            }],
            addNewField() {
              this.fields.push({
                item_division:'',
                item_type:'',
                item_class:'',
                item_name:'',
                quantity:'',
                rate:'',
                amount:'',
               });
               this.globalIndex = this.globalIndex + 1;

               // Reset the Item Type Dropdown
               //    this.shared.itemType = '';

               this.getClassFromOutside(this.shared.itemType);
            },
            removeField(index) {
               this.fields.splice(index, 1);
               this.removeTotalFieldRemoval(index);
               this.globalIndex = this.globalIndex - 1;
               this.shared.itemType = '';
               this.discountPercent = 0;
            },
            async getDivision(event) {
                
                // If division is changed then all other dropdowns should be nulled
                // this.fields[index].types = [];
                // this.fields[index].classes = [];
                // this.fields[index].items = [];
                // this.fields[index].quantity = 0;

                    let data = await (await fetch("{{ route('admin.sports-items.get_sports_item_type') }}?division_id=" + event.target.value)).json();
                    // console.log("data",data.itemType.sport_item_types);
                    this.fields.types = data.itemType.sport_item_types;
                    this.shared.division = event.target.value;
                    // this.fields[index].types = data.itemType.sport_item_types;
                    // this.fields[index].showDropdown =  this.fields[index].types.length > 0;
                    
            },
            async getClassFromOutside(event){
                console.log("itemType",event);
                let data = await (await fetch("{{ route('admin.sports-items.get_sports_classes') }}?item_type=" + event)).json();
                
                // Populate the class
                this.fields[this.globalIndex].classes = data.itemClasses.sport_item_classes;
                // this.getClass(false,data);
            },
            async getClass(event){
                    // this.fields.classes = [];
                    // this.fields.items = [];
                    // this.fields[index].quantity = 0;
                    
                    let data = await (await fetch("{{ route('admin.sports-items.get_sports_classes') }}?item_type=" + event.target.value)).json();
                    this.fields[this.globalIndex].classes = data.itemClasses.sport_item_classes;
                    // Now we have added the item type globally and 
                    // it will be used for every item
                    this.shared.itemType = event.target.value;

            },
            async getItems(index){
                this.fields.items = [];
                this.fields[this.globalIndex].quantity = 0;
                this.fields[this.globalIndex].amount = 0;
                let data = await (await fetch("{{ route('admin.sports-items.get_sports_items') }}?item_class=" + this.fields[[this.globalIndex]].item_class)).json();
                this.fields[this.globalIndex].items = data.itemNames.sport_items;
                this.fields.item_code = data.itemNames.sport_items[[this.globalIndex]].id;
            },
            async getItemDetails(index){
                
                let data = await (await fetch("{{ route('admin.sports-items.get_item_details') }}?item_id=" + this.fields[[this.globalIndex]].item_name)).json();
                this.fields[[this.globalIndex]].itemDetails = data.itemDetails;
                this.fields[[this.globalIndex]].item_code = data.itemDetails.id;
                this.fields[[this.globalIndex]].rate = data.itemDetails.item_rate;
                this.fields[this.globalIndex].quantity = 0;
                this.fields[this.globalIndex].amount = 0;
            },
            async getLot(item_id) {
                let data = await (await fetch("{{ route('admin.store-items.get_lot_by_item') }}?item_id=" + item_id)).json();
            },
            calculateAmount(index) {
                if (this.fields[[this.globalIndex]].quantity) {
                    this.fields[[this.globalIndex]].amount = this.fields[[this.globalIndex]].quantity * this.fields[[this.globalIndex]].rate;
                    this.calculateAllTotals();
                }
                // this.grand_total = this.fields.reduce((accumulator, object) => {
                //     return accumulator + object.amount;
                // }, 0);
            },
            calculateAllTotals(){
                
                // assign the totals

                let Grosstotal = 0;
                let TotalPayable = 0;
                let NetPayable = 0;

                // if(this.payMode == 'card'){
                //     NetPayable += NetPayable * (this.bank_charges_percentage)/100;
                // }
                
                
                let cardTax = 0;
                this.fields.forEach((field) => {
                    if (field.amount) {
                        Grosstotal += parseFloat(field.amount);
                        TotalPayable += parseFloat(field.amount);
                    }
                });

                if(this.payMode == 'card'){
                    cardTax = TotalPayable * (this.bank_charges_percentage)/100;
                    // console.log("cardTax",cardTax);
                    NetPayable += parseFloat(Grosstotal) + cardTax;
                }
                else{
                    NetPayable += parseFloat(Grosstotal);
                }
                
                let deduct_amount_as_discount = this.calculateDiscount();
                // console.log("discounted_amount",deduct_amount_as_discount);
                // Update the elements with the new calculated values
                document.getElementById("gross_total").value = Grosstotal;
                document.getElementById("total_payable").value = TotalPayable;
                document.getElementById("net_payable").value = (TotalPayable - deduct_amount_as_discount).toFixed(2);
                document.getElementById("bank_charges").value = cardTax;
            },
            calculateDiscount(){
                
                let discount = this.discountPercent;
                if(discount == 0){
                    this.displayDiscountAmount = discount;
                    return 0;
                }                
                let net_payable = document.getElementById("net_payable").value;

                discount = (net_payable * discount) / 100;
                this.displayDiscountAmount = discount;
                return discount;
            },
            calculateDiscountOnChange($event){
                
                this.discountPercent = $event.target.value;
                
                
                let total_payable = document.getElementById("total_payable").value;
                if(total_payable){
                    discount = (total_payable * $event.target.value) / 100;
                    document.getElementById("net_payable").value = (total_payable - discount).toFixed(2);
                    this.displayDiscountAmount = discount;
                }


            },
            removeTotalFieldRemoval(index){
                this.calculateAllTotals();
            },
            async getMemberInfo(event) {
                
                let membershipNumber = event.target.value;

                let data = await (await fetch("{{ route('admin.membersInfo.get_member_name') }}?membershipNumber=" + membershipNumber)).json();
                
                if(data.memberInfo){
                    this.memberName = data.memberInfo.name;
                    this.memberStatus = data.memberInfo.membership_status;
                    $(':input[readonly]#membership_status').removeClass('original-background-important');
                    $(':input[readonly]#membership_status').css({'background-color': data.memberInfo.color});
                    document.getElementById("membership_no_error").style.display = 'none';

                    // document.getElementByClass(".memberPhoto").attr('src',data.memberInfo.dependents.media.original_url);
                    $(".memberStatus").text(data.memberInfo.membership_status);
                    
                    if(data.memberInfo.dependents){
                        this.showDependents = true;
                        
                        // Display the dependents data inside the modal
                        
                        // Clear existing content in modal body
                        $(".modal-body").empty();
                        
                        // Iterate through dependents and append information to modal body
                        if(data.memberInfo.dependents.length === 0){
                            $(".modal-body").append('<p>No dependents found for this Member</p>');
                        }

                        // Populate the member photo
                        const imgMemberSrc = data.memberInfo.media.length > 0 ? data.memberInfo.media[0].preview : `https://ui-avatars.com/api/?rounded=true&name=${encodeURIComponent('DEFAULT_NAME')}`; 
                        
                        $(".modal-body").append(`
                            <img src="${imgMemberSrc}" alt="Member Photo" style="border-radius:50%;max-width: 100%; height: 150px;width:150px;">
                        `);

                        data.memberInfo.dependents.forEach(dependent => {
                            const imgSrc = dependent.media.length > 0 ? dependent.media[0].preview : `https://ui-avatars.com/api/?rounded=true&name=${encodeURIComponent('DEFAULT_NAME')}`; 
                            $(".modal-body").append(`
                                <br><br><br>
                                <p>Dependent Name: ${dependent.name}</p>
                                <p>Dependent Relationship: ${dependent.relation}</p>
                                <p>Dependent Date of Birth: ${dependent.dob}</p>
                                <p>Dependent Occupation: ${dependent.occupation}</p>
                                
                                <hr>
                            `);
                        });
                    }
                    
                }

                if(membershipNumber == ''){
                    $(':input[readonly]#membership_status').addClass('original-background-important');
                    this.showDependents = false;
                }
            },
            showBankCharges(event){
                
                if(event.target.value == 'card'){
                    this.payMode = 'card';
                    // document.getElementById("bankCharges").style.display = "table-row";
                    // document.getElementById("bank_charges").value = this.bank_charges_percentage;
                    this.calculateAllTotals();
                }
                else{
                    // document.getElementById("bankCharges").style.display = "none";
                    // document.getElementById("bank_charges").value = this.bank_charges_percentage;
                    this.calculateAllTotals();
                }

            },
            limitQuantityInput(event, index) {
                let inputValue = event.target.value;

                    // Remove any non-digit characters, including decimals
                    inputValue = inputValue.replace(/[^0-9]/g, '');

                    if (inputValue === '') {
                        inputValue = '0'; // Set to 0 if the input is empty
                    }

                    if (parseInt(inputValue) > 1000) {
                        // If the input is greater than 1000, set the quantity to 1000
                        this.fields[index].quantity = 1000;
                    } else {
                        // Update the quantity with the sanitized input
                        this.fields[index].quantity = parseInt(inputValue);
                    }
            },
            watch: {
                
                payMode: function(newPayMode) {
                    if (newPayMode === 'card') {
                        // Calculate and add 2.33% to the total payable
                        this.fields.forEach((field) => {
                            if (field.amount) {
                                field.amount = parseFloat(field.amount);
                                const additionalCharges = (this.bank_charges_percentage / 100) * field.amount;
                                field.amount += additionalCharges;
                            }
                        });
                    }
                    else{
                        // Calculate and add 2.33% to the total payable
                        this.fields.forEach((field) => {
                            if (field.amount) {
                                field.amount = parseFloat(field.amount);
                            }
                        });
                        
                    }

                    this.calculateAllTotals(); // Recalculate totals with additional charges
                },
            },
        };
    };


</script>
@endsection