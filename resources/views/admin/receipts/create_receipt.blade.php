@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>
        {{ trans('global.create') }} {{ trans('cruds.cash_receipts.title_cash_receipt') }}
        </h4>
    </div>

    <form method="POST" action="{{ route("admin.store-receipt",[$order->id]) }}" enctype="multipart/form-data">
    @csrf
        <div class="card-body row" x-data="handler()">
            <div class="form-group col-md-4">
                <label class="" for="name">{{ trans('cruds.cash_receipts.fields.receipt_no') }}</label>
                <input class="form-control" type="text" value="cash-receipt-{{ $order->id }}" name="receipt_no" id="receipt_no" value="{{ old('receipt_no', '') }}" disabled>
            </div>
            <div class="form-group col-md-4">
                <label class="" for="name">{{ trans('cruds.cash_receipts.fields.receipt_date') }}</label>
                <input class="form-control" type="text" value="{{ date('d-m-Y',strtotime($order->created_at) )}}" name="receipt_date" id="receipt_date" value="{{ old('receipt_date', '') }}" disabled>
            </div>
            <div class="form-group col-md-4">
                <label class="" for="name">{{ trans('cruds.cash_receipts.fields.club') }}</label>
                <input class="form-control" type="text" value="PAF Skyviews" name="receipt_club" id="receipt_club" value="{{ old('receipt_club', '') }}" disabled>
            </div>

            <div class="form-group col-md-4">
                <label class="" for="name">{{ trans('cruds.cash_receipts.fields.pay_mode') }}</label>
                <select class="form-control select2 {{ $errors->has('pay_mode') ? 'is-invalid' : '' }}" name="pay_mode" id="pay_mode" required>
                    <option value="" disabled selected>Select Payment Method</option>
                    <option value="Cash" {{ ($order->payment_type == 'cash' ) ? "selected" : "" }}>Cash</option>
                    <option value="Card" {{ ($order->payment_type == 'card' ) ? "selected" : "" }}>Card</option>
                    <option value="Credit" {{ ($order->payment_type == 'credit' ) ? "selected" : "" }}>Credit</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="" for="name">{{ trans('cruds.order.fields.grand_total') }}</label>
                <input class="form-control" type="text" name="grand_total" id="grand_total" value="{{ $order->grand_total }}" disabled>
            </div>

            <div class="form-group col-md-4">
                <label>{{ trans('cruds.order.fields.discount') }}</label>
                <input x-model="discountPercent" x-on:change="calculateDiscountOnChange($event)" class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', '') }}" step="0.01">
            </div>

            <div class="form-group col-md-4">
                <label class="" for="name">{{ trans('cruds.order.fields.after_discount') }}</label>
                <input x-model="afterDiscountAmount" class="form-control" type="text" name="afterDiscountAmount" id="afterDiscountAmount" value="" disabled>
            </div>

            <input type="hidden" name="order_id" value="{{ $order->id }}" id="order">
            {{-- <input type="hidden" name="member_id" value="{{ $order->member->id }}" id="order"> --}}

            <div class="form-group col-md-12">
                <button class="btn btn-success px-5" type="submit">
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
            discountPercent:'0',
            afterDiscountAmount:'0',
            displayDiscountAmount:'0',
            calculateDiscountOnChange($event){
                
                this.discountPercent = $event.target.value;
                console.log("event",this.discountPercent);
                
                let total_payable = document.getElementById("grand_total").value;
                if(total_payable){
                    discount = (total_payable * $event.target.value) / 100;
                    document.getElementById("afterDiscountAmount").value = (total_payable - discount).toFixed(2);
                    this.displayDiscountAmount = discount;
                }


            },
        }; 
    };

</script>
@endsection