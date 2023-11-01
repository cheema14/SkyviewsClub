@extends('layouts.admin')
@section('content')

<div class="card" x-data="handler()">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sportsBilling.title_singular') }}
    </div>

    <form method="POST" action="{{ route("admin.sports-billings.store") }}" enctype="multipart/form-data">
    @csrf
        <div class="card-body row" x-data="{ membershipNo: '', memberName: '', nonMemberName: '' }">
            <div class="form-group col-md-4" x-show="!nonMemberName">
                <label class="required" for="membership_no">{{ trans('cruds.sportsBilling.fields.membership_no') }}</label>
                <input class="form-control {{ $errors->has('membership_no') ? 'is-invalid' : '' }}" x-model="membershipNo" x-on:blur="getMemberInfo($event)" type="text" name="membership_no" id="membership_no" value="{{ old('membership_no', '') }}">
                <p id="membership_no_error" style="color:red;display:none;">Invalid Membership no</p>
                @if($errors->has('membership_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('membership_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.member.fields.membership_no_helper') }}</span>
            </div>
            <div class="form-group col-md-4" x-show="!nonMemberName">
                <label for="member_name">{{ trans('cruds.sportsBilling.fields.member_name') }}</label>
                <input readonly class="form-control {{ $errors->has('member_name') ? 'is-invalid' : '' }}" x-model="memberName" type="text" name="member_name" id="member_name">
                @if($errors->has('member_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.member_name_helper') }}</span>
            </div>
            <div class="form-group col-md-4" x-show="!membershipNo">
                <label for="non_member_name">{{ trans('cruds.sportsBilling.fields.non_member_name') }}</label>
                <input class="form-control {{ $errors->has('non_member_name') ? 'is-invalid' : '' }}" x-model="nonMemberName" type="text" name="non_member_name" id="non_member_name" value="{{ old('non_member_name', '') }}">
                @if($errors->has('non_member_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('non_member_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.non_member_name_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label class="required" for="bill_date">{{ trans('cruds.sportsBilling.fields.bill_date') }}</label>
                <input class="form-control date {{ $errors->has('bill_date') ? 'is-invalid' : '' }}" type="text" name="bill_date" id="bill_date" value="{{ old('bill_date') }}" required>
                @if($errors->has('bill_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bill_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.bill_date_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="bill_number">{{ trans('cruds.sportsBilling.fields.bill_number') }}</label>
                <input readonly class="form-control {{ $errors->has('bill_number') ? 'is-invalid' : '' }}" type="text" name="bill_number" id="bill_number" value="{{ $new_billing_id }}">
                @if($errors->has('bill_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bill_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.bill_number_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="remarks">{{ trans('cruds.sportsBilling.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}">
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="ref_club">{{ trans('cruds.sportsBilling.fields.ref_club') }}</label>
                <input class="form-control {{ $errors->has('ref_club') ? 'is-invalid' : '' }}" type="text" name="ref_club" id="ref_club" value="{{ old('ref_club', '') }}">
                @if($errors->has('ref_club'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ref_club') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.ref_club_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="club_id_ref">{{ trans('cruds.sportsBilling.fields.club_id_ref') }}</label>
                <input class="form-control {{ $errors->has('club_id_ref') ? 'is-invalid' : '' }}" type="text" name="club_id_ref" id="club_id_ref" value="{{ old('club_id_ref', '') }}">
                @if($errors->has('club_id_ref'))
                    <div class="invalid-feedback">
                        {{ $errors->first('club_id_ref') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.club_id_ref_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="tee_off">{{ trans('cruds.sportsBilling.fields.tee_off') }}</label>
                <input class="form-control {{ $errors->has('tee_off') ? 'is-invalid' : '' }}" type="text" name="tee_off" id="tee_off" value="{{ old('tee_off', '') }}">
                @if($errors->has('tee_off'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tee_off') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.tee_off_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="holes">{{ trans('cruds.sportsBilling.fields.holes') }}</label>
                <input class="form-control {{ $errors->has('holes') ? 'is-invalid' : '' }}" type="text" name="holes" id="holes" value="{{ old('holes', '') }}">
                @if($errors->has('holes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('holes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.holes_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="caddy">{{ trans('cruds.sportsBilling.fields.caddy') }}</label>
                <input class="form-control {{ $errors->has('caddy') ? 'is-invalid' : '' }}" type="text" name="caddy" id="caddy" value="{{ old('caddy', '') }}">
                @if($errors->has('caddy'))
                    <div class="invalid-feedback">
                        {{ $errors->first('caddy') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.caddy_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="temp_mbr">{{ trans('cruds.sportsBilling.fields.temp_mbr') }}</label>
                <input class="form-control {{ $errors->has('temp_mbr') ? 'is-invalid' : '' }}" type="text" name="temp_mbr" id="temp_mbr" value="{{ old('temp_mbr', '') }}">
                @if($errors->has('temp_mbr'))
                    <div class="invalid-feedback">
                        {{ $errors->first('temp_mbr') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.temp_mbr_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="temp_caddy">{{ trans('cruds.sportsBilling.fields.temp_caddy') }}</label>
                <input class="form-control {{ $errors->has('temp_caddy') ? 'is-invalid' : '' }}" type="text" name="temp_caddy" id="temp_caddy" value="{{ old('temp_caddy', '') }}">
                @if($errors->has('temp_caddy'))
                    <div class="invalid-feedback">
                        {{ $errors->first('temp_caddy') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.temp_caddy_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label>{{ trans('cruds.sportsBilling.fields.pay_mode') }}</label>
                <select x-on:change="showBankCharges($event)" x-model="payMode" class="form-control {{ $errors->has('pay_mode') ? 'is-invalid' : '' }}" name="pay_mode" id="pay_mode">
                    <option value disabled {{ old('pay_mode', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SportsBilling::PAY_MODE_SELECT as $key => $label)
                        <option x-show="nonMemberName === '' || ['credit'].indexOf('{{ $key }}') === -1" value="{{ $key }}" value="{{ $key }}" {{ old('pay_mode', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                @if($errors->has('pay_mode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pay_mode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.pay_mode_helper') }}</span>
            </div>
            {{-- <div class="form-group col-md-4">
                <label for="gross_total">{{ trans('cruds.sportsBilling.fields.gross_total') }}</label>
                <input class="form-control {{ $errors->has('gross_total') ? 'is-invalid' : '' }}" type="number" name="gross_total" id="gross_total" value="{{ old('gross_total', '') }}" step="1">
                @if($errors->has('gross_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gross_total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.gross_total_helper') }}</span>
            </div> --}}
            {{-- <div class="form-group col-md-4">
                <label for="total_payable">{{ trans('cruds.sportsBilling.fields.total_payable') }}</label>
                <input class="form-control {{ $errors->has('total_payable') ? 'is-invalid' : '' }}" type="number" name="total_payable" id="total_payable" value="{{ old('total_payable', '') }}" step="1">
                @if($errors->has('total_payable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_payable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.total_payable_helper') }}</span>
            </div> --}}
            {{-- <div class="form-group col-md-4" id="bankCharges" style="display:none;">
                <label for="bank_charges">{{ trans('cruds.sportsBilling.fields.bank_charges') }}</label>
                <input class="form-control {{ $errors->has('bank_charges') ? 'is-invalid' : '' }}" readonly type="number" name="bank_charges" id="bank_charges" value="{{ old('bank_charges', '') }}" step="0.01">
                @if($errors->has('bank_charges'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_charges') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.bank_charges_helper') }}</span>
            </div> --}}
            {{-- <div class="form-group col-md-4">
                <label for="net_pay">{{ trans('cruds.sportsBilling.fields.net_pay') }}</label>
                <input class="form-control {{ $errors->has('net_pay') ? 'is-invalid' : '' }}" type="number" name="net_pay" id="net_pay" value="{{ old('net_pay', '') }}" step="0.01">
                @if($errors->has('net_pay'))
                    <div class="invalid-feedback">
                        {{ $errors->first('net_pay') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sportsBilling.fields.net_pay_helper') }}</span>
            </div> --}}
        </div>
        <div class="card-body row">

            <div class="col-md-12">
                <label for="photo">Billing Items</label>
                <table class="table table-bordered align-items-center table-md">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Item Division</th>
                            <th>Item Type</th>
                            <th>Item Class</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            <th>Item Description</th>
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
                                <td>
                                    <select required x-model="field.item_division" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][billing_division_id]`" id="item_division" x-on:change="getDivision(index)">
                                        @foreach($divisions as $id => $entry)
                                        <option value="{{ $id }}" {{ old('item_division') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    {{-- Item Type --}}
                                    <select required x-model="field.item_type" x-on:change="getClass(index)" class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" :name="`items[${index}][billing_item_type_id]`" id="item_type">
                                        <option value="" disabled selected>Select an option</option>
                                            <template x-for="type in field.types">
                                                <option x-text="type.item_type" x-bind:value="type.id"></option>
                                            </template>
                                    </select>
                                </td>
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
                                <td>
                                    {{-- Item Description --}}
                                    <input required x-model="field.item_description" :name="`items[${index}][billing_item_description]`" class="form-control">
                                </td>
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
                    {{ trans('global.save') }}
                </button>
            </div>
        </div>
            
    </form>
</div>



@endsection
@section('scripts')
<script>

    function handler() {

        return {
            payMode:'',
            bank_charges_percentage:2.37,
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
            },
            removeField(index) {
               this.fields.splice(index, 1);
               this.removeTotalFieldRemoval(index);
            },
            async getDivision(index) {
                
                // If division is changed then all other dropdowns should be nulled
                this.fields[index].types = [];
                this.fields[index].classes = [];
                this.fields[index].items = [];
                this.fields[index].quantity = 0;

                    let data = await (await fetch("{{ route('admin.sports-items.get_sports_item_type') }}?division_id=" + this.fields[index].item_division)).json();
                    this.fields[index].types = data.itemType.sport_item_types;
                    // this.fields[index].showDropdown =  this.fields[index].types.length > 0;
                    
            },
            async getClass(index){

                    this.fields.classes = [];
                    this.fields.items = [];
                    this.fields[index].quantity = 0;
                    
                    let data = await (await fetch("{{ route('admin.sports-items.get_sports_classes') }}?item_type=" + this.fields[index].item_type)).json();
                    this.fields[index].classes = data.itemClasses.sport_item_classes;
            },
            async getItems(index){
                this.fields.items = [];
                this.fields[index].quantity = 0;
                let data = await (await fetch("{{ route('admin.sports-items.get_sports_items') }}?item_class=" + this.fields[index].item_class)).json();
                this.fields[index].items = data.itemNames.sport_items;
                this.fields.item_code = data.itemNames.sport_items[index].id;
            },
            async getItemDetails(index){
                
                let data = await (await fetch("{{ route('admin.sports-items.get_item_details') }}?item_id=" + this.fields[index].item_name)).json();
                this.fields[index].itemDetails = data.itemDetails;
                this.fields[index].item_code = data.itemDetails.id;
                this.fields[index].rate = data.itemDetails.item_rate;
                // console.log("itemDetails",this.fields[index].itemDetails);
            },
            async getLot(item_id) {
                let data = await (await fetch("{{ route('admin.store-items.get_lot_by_item') }}?item_id=" + item_id)).json();
            },
            calculateAmount(index) {
                if (this.fields[index].quantity) {
                    this.fields[index].amount = this.fields[index].quantity * this.fields[index].rate;
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
                
                // Update the elements with the new calculated values
                document.getElementById("gross_total").value = Grosstotal;
                document.getElementById("total_payable").value = TotalPayable;
                document.getElementById("net_payable").value = NetPayable;
                document.getElementById("bank_charges").value = cardTax;
            },
            removeTotalFieldRemoval(index){
                this.calculateAllTotals();
            },
            async getMemberInfo(event) {
                
                const membershipNumber = event.target.value;
                
                let data = await (await fetch("{{ route('admin.membersInfo.get_member_name') }}?membershipNumber=" + membershipNumber)).json();
                if(data.memberInfo){
                    document.getElementById("member_name").value = data.memberInfo.name;
                    document.getElementById("membership_no_error").style.display = 'none';
                }
                else{
                    document.getElementById("member_name").value = '';
                    document.getElementById("membership_no").value = '';
                    document.getElementById("membership_no_error").style.display = 'block';
                }
            },
            showBankCharges(event){
                
                if(event.target.value == 'card'){
                    this.payMode = 'card';
                    document.getElementById("bankCharges").style.display = "table-row";
                    document.getElementById("bank_charges").value = this.bank_charges_percentage;
                    this.calculateAllTotals();
                }
                else{
                    document.getElementById("bankCharges").style.display = "none";
                    document.getElementById("bank_charges").value = this.bank_charges_percentage;
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