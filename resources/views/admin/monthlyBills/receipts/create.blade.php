@extends('layouts.admin')
@section('content')
@section('styles')
<style>
    .deposit_div,.cheque_div{
        display:none;
    }

</style>
@endsection
<div class="card">
    <div class="card-header">
        <h4>
            {{ trans('cruds.paymentReceipts.title') }}
        </h4>
    </div>

    <form method="POST" action="{{ route("admin.monthlyBilling.store-bill-receipt") }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="receipt_no">{{ trans('cruds.paymentReceipts.fields.receipt_no') }}</label>
                    <input type="text" name="receipt_no" id="receipt_no" class="form-control" readonly value="mo-re-{{ $receiptNo }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="receipt_date">{{ trans('cruds.paymentReceipts.fields.receipt_date') }}</label>
                    <input type="text" name="receipt_date" id="receipt_date" class="form-control" readonly value="{{ now()->format('Y-m-d') }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="bill_type">{{ trans('cruds.paymentReceipts.fields.bill_type') }}</label>
                    <input type="text" name="bill_type" id="bill_type" class="form-control" value="Monthly Bill" readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="billing_month">{{ trans('cruds.paymentReceipts.fields.billing_month') }}</label>
                    <input type="text" name="billing_month" id="billing_month" class="form-control" value="{{ now()->createFromFormat('Y-m-d', $billDetails->latestBill->bill_month)->format('F Y') }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="invoice_number">{{ trans('cruds.paymentReceipts.fields.invoice_number') }}</label>
                    <input type="text" name="invoice_number" id="invoice_number" class="form-control" value="mo-bi-inv-{{ $billDetails->latestBill->id }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="invoice_amount">{{ trans('cruds.paymentReceipts.fields.invoice_amount') }}</label>
                    <input type="text" name="invoice_amount" id="invoice_amount" class="form-control" value="{{ $billDetails->latestBill->total }}" readonly>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="total_payable">{{ trans('cruds.paymentReceipts.fields.total_payable') }}</label>
                    <input type="text" name="total_payable" id="total_payable" class="form-control" value="{{ $billDetails->arrears }}" readonly>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="received_amount">{{ trans('cruds.paymentReceipts.fields.received_amount') }}</label>
                    <input type="text" name="received_amount" id="received_amount" class="form-control" value="">
                </div>

                <div class="form-group col-md-4">
                    <label for="pay_mode">{{ trans('cruds.paymentReceipts.fields.pay_mode') }}</label>
                    <select class="form-control {{ $errors->has('pay_mode') ? 'is-invalid' : '' }}" name="pay_mode" id="pay_mode">
                        <option value disabled {{ old('pay_mode', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\PaymentReceipt::PAY_MODE as $key => $label)
                                @if ($key != 'Transfer')
                                    <option value="{{ $key }}" {{ old('pay_mode', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endif
                            @endforeach
                    </select>
                </div>

                {{-- Cheque details when pay mode is cheque --}}
                
                <div class="form-group col-md-4 cheque_div">
                    <label for="cheque_number">{{ trans('cruds.paymentReceipts.fields.cheque_number') }}</label>
                    <input type="text" name="cheque_number" id="cheque_number" class="form-control" value="">
                </div>

                <div class="form-group col-md-4 cheque_div">
                    <label for="bank_name">{{ trans('cruds.paymentReceipts.fields.bank_name') }}</label>
                    <select class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" name="bank_name" id="bank_name">
                        <option value disabled {{ old('bank_name', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\PaymentReceipt::BANK_NAMES as $key => $label)
                                @if ($key != 'Transfer')
                                    <option value="{{ $key }}" {{ old('bank_name', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endif
                            @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4 cheque_div">
                    <label for="cheque_date">{{ trans('cruds.paymentReceipts.fields.cheque_date') }}</label>
                    <input type="text" name="cheque_date" id="cheque_date" class="form-control cheque_date" value="">
                </div>

                <div class="form-group col-md-4 cheque_div">
                    <label for="cheque_photo">{{ trans('cruds.paymentReceipts.fields.cheque_photo') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('cheque_photo') ? 'is-invalid' : '' }}" id="cheque-dropzone">
                        </div>
                        @if($errors->has('cheque_photo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('cheque_photo') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.paymentReceipts.fields.cheque_photo_helper') }}</span>
                </div>

                {{-- Deposit details when pay mode is deposit/online etc --}}

                <div class="form-group col-md-4 deposit_div">
                    <label for="deposit_slip_number">{{ trans('cruds.paymentReceipts.fields.deposit_slip_number') }}</label>
                    <input type="text" name="deposit_slip_number" id="deposit_slip_number" class="form-control" value="">
                </div>

                <div class="form-group col-md-4 deposit_div">
                    <label for="deposit_bank_name">{{ trans('cruds.paymentReceipts.fields.deposit_bank_name') }}</label>
                    <select class="form-control {{ $errors->has('deposit_bank_name') ? 'is-invalid' : '' }}" name="deposit_bank_name" id="deposit_bank_name">
                        <option value disabled {{ old('bank_name', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\PaymentReceipt::BANK_NAMES as $key => $label)
                                @if ($key != 'Transfer')
                                    <option value="{{ $key }}" {{ old('deposit_bank_name', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endif
                            @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4 deposit_div">
                    <label for="deposit_date">{{ trans('cruds.paymentReceipts.fields.deposit_date') }}</label>
                    <input type="text" name="deposit_date" id="deposit_date" class="form-control deposit_date" value="">
                </div>

                <div class="form-group col-md-4 deposit_div">
                    <label for="deposit_photo">{{ trans('cruds.paymentReceipts.fields.deposit_photo') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('deposit_photo') ? 'is-invalid' : '' }}" id="deposit-dropzone">
                        </div>
                        @if($errors->has('deposit_photo'))
                            <div class="invalid-feedback">
                                {{ $errors->first('deposit_photo') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.paymentReceipts.fields.deposit_photo_helper') }}</span>
                </div>



                <div class="form-group col-md-6">
                    <button class="btn btn-success px-5 submit_form" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(".cheque_date").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        maxDate: new Date(),
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    $(".deposit_date").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        maxDate: new Date(),
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    $(document).on("change","#pay_mode",function(){
        let pay_mode = $(this).val();

        if(pay_mode == 'Cheque'){
            $(".cheque_div").show();
            $(".deposit_div").hide();
        }
        else if(pay_mode == 'OnlineTransfer'){
            $(".deposit_div").show();
            $(".cheque_div").hide();
        }
        else{
            $(".cheque_div").hide();
            $(".deposit_div").hide();
        }
    })
</script>

{{-- Dropzone scripts for images  --}}
<script>
    Dropzone.options.chequeDropzone = {
    url: '{{ route('admin.paymentReceipts.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="cheque_photo"]').remove()
      $('form').append('<input type="hidden" name="cheque_photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="cheque_photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
    
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>

<script>
    Dropzone.options.depositDropzone = {
    url: '{{ route('admin.paymentReceipts.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="deposit_photo"]').remove()
      $('form').append('<input type="hidden" name="deposit_photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="deposit_photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
    
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>
@endsection