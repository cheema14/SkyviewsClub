@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@section('styles')
<style>
    .deposit_div,.cheque_div{
        display:none;
    }

</style>
@endsection
@include('partials.'.tenant()->id.'.flash_messages')
<div class="card">
    <div class="card-header">
        <h4>
            {{ trans(tenant()->id.'/cruds.paymentReceipts.advance_payment') }}
        </h4>
    </div>

    <form method="POST" action="{{ route("admin.monthlyBilling.store-advance-payment-receipt") }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="receipt_no">{{ trans(tenant()->id.'/cruds.paymentReceipts.fields.receipt_no') }}</label>
                    <input type="text" name="receipt_no" id="receipt_no" class="form-control" readonly value="mo-re-{{ date("M") }}-{{ $receiptNo }}">
                </div>
                
                <div class="form-group col-md-3">
                    <label class="required" for="membership_no">{{ trans(tenant()->id.'/cruds.paymentReceipts.fields.membership_no') }}</label>
                    <input class="form-control {{ $errors->has('membership_no') ? 'is-invalid' : '' }}" type="text" name="membership_no" id="membership_no">
                    <p id="membership_no_error" style="color:red;display:none;">Invalid Membership no</p>
                </div>

                <div class="form-group col-md-3">
                    <label for="member_name">{{ trans(tenant()->id.'/cruds.sportsBilling.fields.member_name') }}</label>
                    <input readonly class="form-control {{ $errors->has('member_name') ? 'is-invalid' : '' }}" type="text" name="member_name" id="member_name">
                </div>

                <div class="form-group col-md-3">
                    <label for="membership_status_label">{{ trans(tenant()->id.'/cruds.paymentReceipts.fields.membership_status') }}</label>
                    <input readonly class="form-control {{ $errors->has('membership_status') ? 'is-invalid' : '' }}" x-model="memberStatus" type="text" name="membership_status" id="membership_status">
                </div>

                <div class="form-group col-md-3">
                    <label for="received_amount">{{ trans(tenant()->id.'/cruds.paymentReceipts.fields.received_amount') }}</label>
                    <input type="text" name="received_amount" id="received_amount" class="form-control" value="">
                </div>
                <input type="hidden" name="receipt_date" value="{{ date('Y-m-d') }}" >
                <input type="hidden" name="pay_mode" value="{{ App\Models\PaymentReceipt::PAY_MODE["Arrear"] }}" >
                <input type="hidden" name="member_id" id="member_id" value="" >
                <div class="form-group col-md-12">
                    <button class="btn btn-success px-5 submit_form" type="submit">
                        {{ trans(tenant()->id.'/global.save') }}
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')

<script type="text/javascript">
    
    $(document).on("change","#membership_no",async function(event){
        
        let membershipNumber = event.target.value;
        

        let data = await (await fetch("{{ route('admin.membersInfo.get_member_name') }}?membershipNumber=" + membershipNumber)).json();
        
        if(data.memberInfo.name && data.memberInfo.membership_status){
            $(':input[readonly]#membership_status').removeClass('original-background-important');
            $(':input[readonly]#membership_status').css({'background-color': data.memberInfo.color});
            document.getElementById("membership_no_error").style.display = 'none';
            document.getElementById("member_name").value = data.memberInfo.name;
            document.getElementById("membership_status").value = data.memberInfo.membership_status;
            document.getElementById("member_id").value = data.memberInfo.id;
            
        }
        else{
            document.getElementById("member_name").value = '';
            document.getElementById("membership_status").value = '';
            $(':input[readonly]#membership_status').css('background-color:#d8dbe0');
        }


    });
    
</script>
@endsection