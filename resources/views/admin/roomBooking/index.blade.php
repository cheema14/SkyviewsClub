@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@include('partials.'.tenant()->id.'.flash_messages')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/cruds.roomBooking.title_singular') }} {{ trans(tenant()->id.'/global.list') }}
        
        <form style="margin-top:50px;" method="GET" action="{{ route('admin.roomBooking.listAllBookings') }}">
        
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="checkin_date">Checkin Date:</label>
                    <input type="text" name="checkin_date" class="form-control date" value="{{ request('checkin_date') }}">
                </div>
            
                <div class="form-group col-md-3">
                    <label for="checkout_date">Checkout Date:</label>
                    <input type="text" name="checkout_date" class="form-control date" value="{{ request('checkout_date') }}">
                </div>
            
                {{-- <div class="form-group col-md-3">
                    <label for="booking_category">{{ trans(tenant()->id.'/cruds.roomBooking.fields.booking_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="booking_category" id="designation_id">
                        <option value="" disabled selected>Select Category</option>
                        @foreach ($bookingCategories as $category )
                            <option value="{{ $category->id }}" {{ request('booking_category') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="form-group col-md-3">
                    <label for="room_category">{{ trans(tenant()->id.'/cruds.roomBooking.fields.room_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="room_category" id="designation_id">
                        <option value="" disabled selected>Select Category</option>
                        <option value="1" {{ request('room_category') == 1 ? 'selected' : '' }}>Deluxe</option>
                        <option value="2" {{ request('room_category') == 2 ? 'selected' : '' }}>Suite</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="status">Booking Status:</label>
                    <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="designation_id">
                        <option value="" disabled selected>Select Status</option>
                        @foreach (App\Models\RoomBooking::BOOKING_STATUS as $status )
                            @if ($status != 'Stalled' && $status != 'Accepted')
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

            </div>
        
            <button type="submit" class="btn btn-info">Search</button>
            <a href="{{ route('admin.roomBooking.listAllBookings') }}" class="btn btn-danger">Reset</a>
        </form>
        <div class="row">
            <div class="col-md-4 mt-2">
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.roomBooking.bookRoomManually') }}"  class="btn btn-warning"><strong>Book Room</strong></a>
            </div>
            <div class="col-md-4"></div>
        </div>

    </div>

    
    
        

    <div class="card-body">
        
        

            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-MemberFeedback">
                        <thead>
                            <tr>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.id') }}
                                </th>
                                {{-- <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.booking_category') }}
                                </th> --}}
                                <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.room_category') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.member.fields.name') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.member.fields.membership_no') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.checkin_date') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.checkout_date') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.booking_rate') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.total_bill') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.status') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.no_of_days') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/cruds.roomBooking.fields.discount') }}
                                </th>
                                <th>
                                    {{ trans(tenant()->id.'/global.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roomBookings as $key => $roomBooking)
                            <tr data-entry-id="{{ $roomBooking->id }}">
                                <td>
                                    {{ $roomBooking->id ?? '' }}
                                </td>
                                {{-- <td>
                                    {{ $roomBooking->bookingCategory->title ?? '' }}
                                </td> --}}
                                <td>
                                    {{ $roomBooking->roomCategory->title ?? '' }}
                                </td>
                                <td>
                                    {{ $roomBooking->member->name ?? '' }}
                                </td>
                                <td>
                                    {{ $roomBooking->member->membership_no ?? '' }}
                                </td>
                                <td style="min-width: 70px;">
                                    {{ $roomBooking->checkin_date ?? '' }}
                                </td>
                                <td style="min-width: 70px;">
                                    {{ $roomBooking->checkout_date ?? '' }}
                                </td>
                                <td>
                                    {{ $roomBooking->price_at_booking_time ?? '' }}
                                </td>
                                <td>
                                    {{ $roomBooking->total_price ?? '' }}
                                </td>
                                <td>
                                    {{ $roomBooking->status ?? '' }}
                                </td>
                                <td>
                                    {{ $roomBooking->no_of_days ?? '' }}
                                </td>
                                <td>
                                    {{ $roomBooking->discount ?? '' }}
                                </td>
                                
                                <td>
                                    @can('room_booking_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.roomBooking.showBooking', $roomBooking->id) }}">
                                            <i class="fa fa-eye"  aria-hidden="true"></i>
                                        </a>
                                    @endcan

                                    <a class="btn btn-xs btn-primary"  target="_blank" href="{{ route('admin.roomBooking.printBookingReceipt', $roomBooking->id) }}">
                                        <i class="fa fa-print" title="Print Booking Receipt" aria-hidden="true"></i>
                                    </a>
                                     

                                    @if ($roomBooking->roomBookingTransactions->first() && $roomBooking->roomBookingTransactions->first()->type == App\Models\Transaction::TYPE_SELECT['Credit'])
                                        <a class="btn btn-xs btn-primary"  target="_blank" href="{{ route("admin.monthlyBilling.create-bill-receipt",['id' => $roomBooking->id]) }}">
                                            <i class="fas fa-receipt fa-lg" title="Create Booking Receipts" aria-hidden="true"></i>
                                        </a>
                                    @endif

                                    @if ($roomBooking->status == App\Models\RoomBooking::BOOKING_STATUS['pending'])
                                        {{-- @can('room_booking_delete')
                                            <form action="{{ route('admin.room-booking.destroy', $roomBooking->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </form>
                                        @endcan --}}
                                        @can('room_booking_approve')
                                            <form action="{{ route('admin.roomBooking.approveBooking', $roomBooking->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/cruds.roomBooking.fields.approve_sure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="status" value="{{ App\Models\RoomBooking::BOOKING_STATUS['booked'] }}">
                                                <input type="submit" class="btn btn-xs btn-success" value="{{ trans(tenant()->id.'/cruds.roomBooking.fields.approve_booking') }}">
                                            </form>
                                        @endcan

                                        @can('room_booking_approve')
                                            <form action="{{ route('admin.roomBooking.rejectBooking', $roomBooking->id) }}" method="POST" onsubmit="return confirm('{{ trans(tenant()->id.'/cruds.roomBooking.fields.reject_sure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="status" value="{{ App\Models\RoomBooking::BOOKING_STATUS['rejected'] }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans(tenant()->id.'/cruds.roomBooking.fields.reject_booking') }}">
                                            </form>
                                        @endcan
                                    @endif

                                    
                                    @if($roomBooking->status == App\Models\RoomBooking::BOOKING_STATUS['booked'])
                                        <a class="btn btn-xs btn-primary"  target="_blank" href="{{ route("admin.roomBooking.printBookingConfirmation",['roomBooking' => $roomBooking]) }}">
                                            <i class="fas fa-check fa-lg" title="Create Booking Confirmation Receipts" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                </td>
    
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        

    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    // order: [[ 1, 'desc' ]],
    pageLength: 20,
  });
  let table = $('.datatable-MemberFeedback:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>

@endsection