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