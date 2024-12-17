@if (session('created'))
    <div class="alert alert-success">
        {{ session('created') }}
    </div>
@endif

@if (session('updated'))
    <div class="alert alert-primary">
        {{ session('updated') }}
    </div>
@endif

@if (session('fail'))
    <div class="alert alert-danger">
        {{ session('fail') }}
    </div>
@endif

@if (session('deleted'))
    <div class="alert alert-warning">
        {{ session('deleted') }}
    </div>
@endif

@if (session('billExists'))
    <div class="alert alert-warning">
        {{ session('billExists') }}
    </div>
@endif

@if (session('billing_amount'))
    <div class="alert alert-warning">
        {{ session('billing_amount') }}
    </div>
@endif

@if (session('roomBooking_deleted'))
    <div class="alert alert-warning">
        {{ session('roomBooking_deleted') }}
    </div>
@endif

@if (session('payment_complete'))
    <div class="alert alert-success">
        {{ session('payment_complete') }}
    </div>
@endif

@if (session('booking_expired'))
    <div class="alert alert-danger">
        {{ session('booking_expired') }}
    </div>
@endif

@if (session('memberNotFound'))
    <div class="alert alert-danger">
        {{ session('memberNotFound') }}
    </div>
@endif

@if (session('roomBooked'))
    <div class="alert alert-success">
        {{ session('roomBooked') }}
    </div>
@endif

@if (session('missingParams'))
    <div class="alert alert-danger">
        {{ session('missingParams') }}
    </div>
@endif