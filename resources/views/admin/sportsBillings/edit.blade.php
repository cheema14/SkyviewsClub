@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.edit') }} {{ trans(tenant()->id.'/cruds.sportsBilling.title_singular') }}
    </div>

    <form method="POST" action="{{ route("admin.sports-billings.update", [$sportsBilling->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card-body row">
            @if ($sportsBilling->membership_no )
                <div class="form-group col-md-4">
                    <label for="membership_no">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.membership_no') }}</label>
                    <input readonly class="form-control {{ $errors->has('membership_no') ? 'is-invalid' : '' }}" type="text" name="membership_no" id="membership_no" value="{{ old('membership_no', $sportsBilling->membership_no) }}">
                    @if($errors->has('membership_no'))
                        <div class="invalid-feedback">
                            {{ $errors->first('membership_no') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.member_name_helper') }}</span>
                </div>
                <div class="form-group col-md-4">
                    <label for="member_name">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.member_name') }}</label>
                    <input readonly class="form-control {{ $errors->has('member_name') ? 'is-invalid' : '' }}" type="text" name="member_name" id="member_name" value="{{ old('member_name', $sportsBilling->member_name) }}">
                    @if($errors->has('member_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('member_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.member_name_helper') }}</span>
                </div>
                
            @endif
            @if (!$sportsBilling->membership_no )
                <div class="form-group col-md-4">
                    <label for="non_member_name">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.non_member_name') }}</label>
                    <input class="form-control {{ $errors->has('non_member_name') ? 'is-invalid' : '' }}" x-model="nonMemberName" type="text" name="non_member_name" id="non_member_name" value="{{ old('non_member_name', $sportsBilling->non_member_name) }}">
                    @if($errors->has('non_member_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('non_member_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.non_member_name_helper') }}</span>
                </div>
            @endif
            <div class="form-group col-md-4">
                <label class="required" for="bill_date">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_date') }}</label>
                <input disabled class="form-control date {{ $errors->has('bill_date') ? 'is-invalid' : '' }}" type="text" name="bill_date" id="bill_date" value="{{ old('bill_date', $sportsBilling->bill_date) }}" required>
                @if($errors->has('bill_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bill_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_date_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="bill_number">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_number') }}</label>
                <input class="form-control {{ $errors->has('bill_number') ? 'is-invalid' : '' }}" type="text" name="bill_number" id="bill_number" value="{{ old('bill_number', $sportsBilling->bill_number) }}">
                @if($errors->has('bill_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bill_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bill_number_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="remarks">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', $sportsBilling->remarks) }}">
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="ref_club">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.ref_club') }}</label>
                <input class="form-control {{ $errors->has('ref_club') ? 'is-invalid' : '' }}" type="text" name="ref_club" id="ref_club" value="{{ old('ref_club', $sportsBilling->ref_club) }}">
                @if($errors->has('ref_club'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ref_club') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.ref_club_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="club_id_ref">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.club_id_ref') }}</label>
                <input class="form-control {{ $errors->has('club_id_ref') ? 'is-invalid' : '' }}" type="text" name="club_id_ref" id="club_id_ref" value="{{ old('club_id_ref', $sportsBilling->club_id_ref) }}">
                @if($errors->has('club_id_ref'))
                    <div class="invalid-feedback">
                        {{ $errors->first('club_id_ref') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.club_id_ref_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="tee_off">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.tee_off') }}</label>
                <input class="form-control {{ $errors->has('tee_off') ? 'is-invalid' : '' }}" type="text" name="tee_off" id="tee_off" value="{{ old('tee_off', $sportsBilling->tee_off) }}">
                @if($errors->has('tee_off'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tee_off') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.tee_off_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="holes">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.holes') }}</label>
                <input class="form-control {{ $errors->has('holes') ? 'is-invalid' : '' }}" type="text" name="holes" id="holes" value="{{ old('holes', $sportsBilling->holes) }}">
                @if($errors->has('holes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('holes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.holes_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="caddy">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.caddy') }}</label>
                <input class="form-control {{ $errors->has('caddy') ? 'is-invalid' : '' }}" type="text" name="caddy" id="caddy" value="{{ old('caddy', $sportsBilling->caddy) }}">
                @if($errors->has('caddy'))
                    <div class="invalid-feedback">
                        {{ $errors->first('caddy') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.caddy_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="temp_mbr">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_mbr') }}</label>
                <input class="form-control {{ $errors->has('temp_mbr') ? 'is-invalid' : '' }}" type="text" name="temp_mbr" id="temp_mbr" value="{{ old('temp_mbr', $sportsBilling->temp_mbr) }}">
                @if($errors->has('temp_mbr'))
                    <div class="invalid-feedback">
                        {{ $errors->first('temp_mbr') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_mbr_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="temp_caddy">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_caddy') }}</label>
                <input class="form-control {{ $errors->has('temp_caddy') ? 'is-invalid' : '' }}" type="text" name="temp_caddy" id="temp_caddy" value="{{ old('temp_caddy', $sportsBilling->temp_caddy) }}">
                @if($errors->has('temp_caddy'))
                    <div class="invalid-feedback">
                        {{ $errors->first('temp_caddy') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.temp_caddy_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label>{{ trans(tenant()->id.'/cruds.sportsBilling.fields.pay_mode') }}</label>
                <select class="form-control {{ $errors->has('pay_mode') ? 'is-invalid' : '' }}" name="pay_mode" id="pay_mode">
                    <option value disabled {{ old('pay_mode', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\SportsBilling::PAY_MODE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('pay_mode', $sportsBilling->pay_mode) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                <label for="gross_total">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.gross_total') }}</label>
                <input readonly class="form-control {{ $errors->has('gross_total') ? 'is-invalid' : '' }}" type="number" name="gross_total" id="gross_total" value="{{ old('gross_total', $sportsBilling->gross_total) }}" step="1">
                @if($errors->has('gross_total'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gross_total') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.gross_total_helper') }}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="total_payable">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.total_payable') }}</label>
                <input readonly class="form-control {{ $errors->has('total_payable') ? 'is-invalid' : '' }}" type="number" name="total_payable" id="total_payable" value="{{ old('total_payable', $sportsBilling->total_payable) }}" step="1">
                @if($errors->has('total_payable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_payable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.total_payable_helper') }}</span>
            </div>
            @if ($sportsBilling->pay_mode == 'card')
                <div class="form-group col-md-4">
                    <label for="bank_charges">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bank_charges') }}</label>
                    <input readonly class="form-control {{ $errors->has('bank_charges') ? 'is-invalid' : '' }}" type="number" name="bank_charges" id="bank_charges" value="{{ old('bank_charges', $sportsBilling->bank_charges) }}" step="0.01">
                    @if($errors->has('bank_charges'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bank_charges') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.bank_charges_helper') }}</span>
                </div>
            @endif
            <div class="form-group col-md-4">
                <label for="net_pay">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.net_pay') }}</label>
                <input readonly class="form-control {{ $errors->has('net_pay') ? 'is-invalid' : '' }}" type="number" name="net_pay" id="net_pay" value="{{ old('net_pay', $sportsBilling->net_pay) }}" step="0.01">
                @if($errors->has('net_pay'))
                    <div class="invalid-feedback">
                        {{ $errors->first('net_pay') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.net_pay_helper') }}</span>
            </div>
        </div>
        <div class="card-body row" >
            
            <div class="form-group col-md-4">
                <button class="btn btn-danger" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>

        </div>
            
    </form>
</div>



@endsection


<script>

    function editHandler() {

        return {
          fields: [
            {
                item_division:'',
                item_type:'',
                item_class:'',
                item_name:'',
                item_description:'',
                quantity:'',
                rate:'',
                amount:'',
                types:[],
                classes:[],
                items:[],
                itemDetails:[],
                showDropdown:false,
                showClassDropdown:false,
                showItemDropdown:false,
            }
            ],
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
            },
            async getDivision(index) {
                
                // If division is changed then all other dropdowns should be nulled
                this.fields[index].types = [];
                this.fields[index].classes = [];
                this.fields[index].items = [];

                    let data = await (await fetch("{{ route('admin.sports-items.get_sports_item_type') }}?division_id=" + this.fields[index].item_division)).json();
                    this.fields[index].types = data.itemType.sport_item_types;
                    // this.fields[index].showDropdown =  this.fields[index].types.length > 0;
                    
            },
            async getClass(index){

                    this.fields.classes = [];
                    this.fields.items = [];
                    
                    let data = await (await fetch("{{ route('admin.sports-items.get_sports_classes') }}?item_type=" + this.fields[index].item_type)).json();
                    this.fields[index].classes = data.itemClasses.sport_item_classes;
            },
            async getItems(index){
                this.fields.items = [];
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
                }

                // this.grand_total = this.fields.reduce((accumulator, object) => {
                //     return accumulator + object.amount;
                // }, 0);
            },
            
        }
    };


    </script>