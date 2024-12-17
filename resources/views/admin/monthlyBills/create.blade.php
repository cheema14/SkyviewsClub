@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.monthlyBill.title_singular') }}
    </div>

    <div class="card-body" x-data="handler()">
        <form method="POST" action="{{ route("admin.monthly-bills.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="bill_date">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.bill_date') }}</label>
                <input class="form-control arrear_date {{ $errors->has('bill_date') ? 'is-invalid' : '' }}" type="text" name="bill_date" id="bill_date" value="{{ old('bill_date') }}" required>
                @if($errors->has('bill_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bill_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.bill_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="membership_no">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.membership_no') }}</label>
                <input class="form-control {{ $errors->has('membership_no') ? 'is-invalid' : '' }}" x-model="membershipNo" x-on:blur="getMemberInfo($event)" type="text" name="membership_no" id="membership_no" value="{{ old('membership_no', '') }}">
                <p id="membership_no_error" style="color:red;display:none;">Invalid Membership no</p>
                @if($errors->has('membership_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('membership_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.membership_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="member_name">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.member_name') }}</label>
                <input readonly class="form-control {{ $errors->has('member_name') ? 'is-invalid' : '' }}" x-model="memberName" type="text" name="member_name" id="member_name">
                @if($errors->has('member_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.member_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="billing_amount">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.billing_amount') }}</label>
                <input class="form-control {{ $errors->has('billing_amount') ? 'is-invalid' : '' }}" type="number" name="billing_amount" id="billing_amount" value="{{ old('billing_amount', '') }}" max="2000000" required>
                @if($errors->has('billing_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('billing_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.billing_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.status') }}</label>
                <select class="form-control" name="status">
                    <option disabled> Select Billing Status</option>
                    <option selected value="Unpaid">Unpaid</option>
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.monthlyBill.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function(){

        $(".arrear_date").datetimepicker({
            format: "YYYY-MM-DD",
            locale: "en",
            minDate: moment().startOf('month'),
            maxDate: moment().endOf('month'),
            icons: {
                up: "fas fa-chevron-up",
                down: "fas fa-chevron-down",
                previous: "fas fa-chevron-left",
                next: "fas fa-chevron-right",
            },
        });
    });
</script>
<script>

    function handler() {

        return {
            membershipNo:'',
            memberName:'',
            async getMemberInfo(event) {
                
                const membershipNumber = event.target.value;
                
                let data = await (await fetch("{{ route('admin.membersInfo.get_member_name') }}?membershipNumber=" + membershipNumber)).json();
                if(data.memberInfo){
                    this.memberName = data.memberInfo.name;
                    document.getElementById("membership_no_error").style.display = 'none';
                }
                else{
                    // document.getElementById("member_name").value = '';
                    document.getElementById("membership_no").value = '';
                    document.getElementById("membership_no_error").style.display = 'block';
                }
            },
        };
    };


</script>
@endsection