@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.show') }} {{ trans(tenant()->id.'/cruds.roomBooking.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roomBooking.listAllBookings') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.roomBooking.fields.id') }}
                        </th>
                        <td>
                            {{ $roomBooking->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.member.fields.name') }}
                        </th>
                        <td>
                            {{ $roomBooking->member->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.member.fields.membership_no') }}
                        </th>
                        <td>
                            {{ $roomBooking->member->membership_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.roomBooking.fields.booking_category') }}
                        </th>
                        <td>
                            {{ $roomBooking->bookingCategory?->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.roomBooking.fields.room_category') }}
                        </th>
                        <td>
                            {{ $roomBooking->roomCategory?->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.roomBooking.fields.checkin_date') }}
                        </th>
                        <td>
                            {{ $roomBooking->checkin_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.roomBooking.fields.checkout_date') }}
                        </th>
                        <td>
                            {{ $roomBooking->checkout_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.roomBooking.fields.booking_rate') }}
                        </th>
                        <td>
                            {{ $roomBooking->price_at_booking_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.roomBooking.fields.total_bill') }}
                        </th>
                        <td>
                            {{ $roomBooking->total_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.roomBooking.fields.no_of_days') }}
                        </th>
                        <td>
                            {{ $roomBooking->no_of_days }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.roomBooking.fields.status') }}
                        </th>
                        <td>
                            {{ $roomBooking->status }}
                        </td>
                    </tr>
                    @if ($roomBooking->booking_has_guests)
                        <tr>
                            <th>
                                {{ trans(tenant()->id.'/cruds.roomBooking.fields.guest_name') }}
                            </th>
                            <td>
                                {{ $roomBooking->guest_name ??  'N/A'}}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans(tenant()->id.'/cruds.roomBooking.fields.guest_cnic') }}
                            </th>
                            <td>
                                {{ $roomBooking->guest_cnic ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans(tenant()->id.'/cruds.roomBooking.fields.guest_mobile_no') }}
                            </th>
                            <td>
                                {{ $roomBooking->guest_mobile_no ?? 'N/A' }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>
                            {{ trans(tenant()->id.'/cruds.member.fields.showPhoto') }}
                        </th>
                        <td>
                            <div class="member-img-box">
                                <a target="_blank" href="{{ route("admin.members.show", $roomBooking->member?->id) }}">
                                    <img src="{{ $roomBooking->member->photo?->getUrl('preview') ?? 'https://ui-avatars.com/api/?rounded=true&name='.urlencode($roomBooking->member->name) }}" alt="Member Image" class="img-fluid">
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            {{-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roomBooking.listAllBookings') }}">
                    {{ trans(tenant()->id.'/global.back_to_list') }}
                </a>
            </div> --}}
        </div>
    </div>
</div>



@endsection