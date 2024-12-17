@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@section('styles')
<style>
    .deposit_div,.cheque_div{
        display:none;
    }

    .billing_section_other{
        display:none;
    }

</style>
@endsection
@include('partials.'.tenant()->id.'.flash_messages')
<div class="card">
    <div class="card-header">
        <h4>
            {{ trans(tenant()->id.'/cruds.paymentReceipts.title') }}
        </h4>
    </div>

    <form method="POST" action="{{ route("admin.monthlyBilling.store-billing-section-payment-receipt") }}" enctype="multipart/form-data">
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
                    <label for="membership_status_label">{{ trans(tenant()->id.'/cruds.paymentReceipts.fields.billing_section') }}</label>
                    <select class="form-control {{ $errors->has('billing_section') ? 'is-invalid' : '' }} billing_section" name="billing_section" id="billing_section">
                            <option value="" selected disabled>Select Billing Section</option>
                            @foreach (App\Models\PaymentReceipt::BILLING_SECTION as $key=>$section )
                                <option value="{{ $key }}">{{ $section }}</option>
                            @endforeach
                            {{-- <option value="Card">Card</option>
                            <option value="Locker">Locker</option>
                            <option value="Others">Others</option>
                            <option value="Restaurant">Restaurant Bill</option>
                            <option value="Snooker">Snooker Room</option>
                            <option value="Proshop">Proshop</option>
                            <option value="Practice">Practice Range</option>
                            <option value="GolfSimulator">Golf Simulator</option>
                            <option value="GolfLocker">Golf Locker</option>
                            <option value="GolfCourse">Golf Course</option>
                            <option value="GolfCartFee">Golf Cart Fee</option> --}}
                    </select>
                </div>

                <div class="form-group col-md-3 billing_section_other">
                    <label for="billing_section_other">{{ trans(tenant()->id.'/cruds.paymentReceipts.fields.billing_section_other') }}</label>
                    <input type="text" name="billing_section_other" id="billing_section_other" class="form-control" value="">
                </div>
                
                <div class="form-group col-md-3">
                    <label for="received_amount">{{ trans(tenant()->id.'/cruds.paymentReceipts.fields.received_amount') }}</label>
                    <input type="text" name="received_amount" id="received_amount" class="form-control" value="">
                </div>
                
                <div class="form-group col-md-3">
                    <label class="required" for="billing_month">{{ trans(tenant()->id.'/cruds.paymentReceipts.fields.billing_month') }}</label>
                    <select name="billing_month" class="form-control" required>
                        <option>Select Month</option>
                        <option value="{{ $currentMonth->format('Y-m') }}">
                            {{ $currentMonth->format('F Y') }} - Bill of {{ $currentMonth->subMonth()->format('M-Y') }}
                        </option>
                        <option value="{{ $nextMonth->format('Y-m') }}">
                            {{ $nextMonth->format('F Y') }} - Bill of {{ $currentMonth->addMonth()->format('M-Y') }}
                        </option>
                    </select>
                </div>

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
            
        }
        else{
            document.getElementById("member_name").value = '';
            document.getElementById("membership_status").value = '';
            $(':input[readonly]#membership_status').css('background-color:#d8dbe0');
        }


    });

    $(document).on("change","#billing_section",function(){

        if($(this).val() == "Others"){
            $(".billing_section_other input").val('');
            $(".billing_section_other").show();
        }
        else{
            $(".billing_section_other").hide();
        }

    });
    
</script>
@endsection