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

@if (session('out_of_stock'))
    <div class="alert alert-danger">
        {{ session('out_of_stock') }}
    </div>
@endif

@if (session('memberNotFound'))
    <div class="alert alert-danger">
        {{ session('memberNotFound') }}
    </div>
@endif

@if (session('ordercancelled'))
<div class="alert alert-success">
    {{ session('ordercancelled') }}
</div>
@endif

@if (session('billPaid'))
    <div class="alert alert-danger">
        {{ session('billPaid') }}
    </div>
@endif

@if (session('completedOrderCantView'))
    <div class="alert alert-danger">
        {{ session('completedOrderCantView') }}
    </div>
@endif