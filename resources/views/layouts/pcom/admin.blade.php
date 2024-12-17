<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans(tenant()->id.'/panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    {{-- <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
    <link href="{{ asset('css/coreui.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" /> --}}

    {{-- Alternate to Select2 because select2 has conflicts with AlpineJS --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.3/dist/css/tom-select.default.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">

    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>

.tom-select {
    font-size: 14px; /* Adjust the font size */
    color: #333; /* Change text color */
}

.tom-select .tomselect-input {
    border: 1px solid #ccc; /* Change border color */
}

.tom-select .option {
    padding: 10px; /* Increase padding for better spacing */
}

.tom-select .selected {
    background-color: #007bff; /* Change background for selected options */
    color: #fff; /* Change text color for selected options */
}
    </style>

    @yield('styles')
</head>

<body class="c-app">
    @include('partials.'.tenant()->id.'.menu')
    <div class="c-wrapper">
        <header class="c-header c-header-fixed px-3">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            <a class="c-header-brand d-lg-none" href="#">{{ trans(tenant()->id.'panel.site_title') }}</a>

            <button class="c-header-toggler mfs-3 d-md-down-none" type="button" responsive="true">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            <ul class="c-header-nav ml-auto">
                @if(count(config('panel.available_languages', [])) > 1)
                <li class="c-header-nav-item dropdown d-md-down-none">
                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach(config('panel.available_languages') as $langLocale => $langName)
                        <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                        @endforeach
                    </div>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ 'https://ui-avatars.com/api/?rounded=true&name='.urlencode(auth()->user()->name) }}" width="40" height="40" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu" style="margin-left: -80px;width:100%;" aria-labelledby="navbarDropdownMenuLink">

                        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                        @can('profile_password_edit')
                        <a class="dropdown-item {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                            {{ trans(tenant()->id.'/global.change_password') }}
                        </a>
                        @endcan
                        @endif

                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">Log Out</a>
                    </div>
                </li>
            </ul>
            {{-- <div>
                avatar here
            </div> --}}
        </header>

        <div class="c-body">
            <main class="c-main pt-0">


                <div class="container-fluid">
                    @if(session('message'))
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                    @endif
                    @if($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @yield('content')

                </div>


            </main>
            <form id="logoutform" action="{{ route('admin.tenant.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.4.0/dist/js/coreui.bundle.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    {{-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script> --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    
    {{-- Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    
    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Alpine Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Bootstrap Validator for change password --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.min.js"></script>
    {{-- <script type="text/javascript">
        var popbox = new Popbox({
              blur:true,
              overlay:true,
            });
      </script> --}}
    
    <script src="{{ asset('js/good_receipt_alpine.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.3/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    {{-- <script src="{{ asset('js/bootstrap-select.min.js') }}"></script> --}}
    <script>
        $(function() {
            // let copyButtonTrans = '{{ trans(tenant()->id.'global.datatables.copy') }}'
            let csvButtonTrans = '{{ trans(tenant()->id.'/global.datatables.csv') }}'
            let excelButtonTrans = '{{ trans(tenant()->id.'/global.datatables.excel') }}'
            let pdfButtonTrans = '{{ trans(tenant()->id.'/global.datatables.pdf') }}'
            // let printButtonTrans = '{{ trans(tenant()->id.'global.datatables.print') }}'
            // let colvisButtonTrans = '{{ trans(tenant()->id.'global.datatables.colvis') }}'
            // let selectAllButtonTrans = '{{ trans(tenant()->id.'global.select_all') }}'
            // let selectNoneButtonTrans = '{{ trans(tenant()->id.'global.deselect_all') }}'

            let languages = {
                'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
            };

            $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
                className: 'btn'
            })
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: languages['{{ app()->getLocale() }}']
                }
                , columnDefs: [
                    // {
                    //     orderable: false,
                    //     className: 'select-checkbox',
                    //     targets: 0
                    // },
                    {
                        orderable: false
                        , searchable: false
                        , targets: -1
                    }
                ],
                // select: {
                //   style:    'multi+shift',
                //   selector: 'td:first-child'
                // },
                order: []
                , scrollX: true
                , pageLength: 100
                , dom: 'lBfrtip<"actions">'
                , buttons: [
                    // {
                    //   extend: 'selectAll',
                    //   className: 'btn-primary',
                    //   text: selectAllButtonTrans,
                    //   exportOptions: {
                    //     columns: ':visible'
                    //   },
                    //   action: function(e, dt) {
                    //     e.preventDefault()
                    //     dt.rows().deselect();
                    //     dt.rows({ search: 'applied' }).select();
                    //   }
                    // },
                    // {
                    //   extend: 'selectNone',
                    //   className: 'btn-primary',
                    //   text: selectNoneButtonTrans,
                    //   exportOptions: {
                    //     columns: ':visible'
                    //   }
                    // },
                    // {
                    //   extend: 'copy',
                    //   className: 'btn-default',
                    //   text: copyButtonTrans,
                    //   exportOptions: {
                    //     columns: ':visible'
                    //   }
                    // },
                    // {
                    //   extend: 'csv',
                    //   className: 'btn-default',
                    //   text: csvButtonTrans,
                    //   exportOptions: {
                    //     columns: ':visible'
                    //   }
                    // },
                    {
                        extend: 'excel'
                        , className: 'btn-default'
                        , text: excelButtonTrans
                        , exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    // {
                    //   extend: 'pdf',
                    //   className: 'btn-info',
                    //   text: pdfButtonTrans,
                    //   exportOptions: {
                    //     columns: ':visible:not(:last-child)'
                    //   }
                    // },
                    // {
                    //   extend: 'print',
                    //   className: 'btn-default',
                    //   text: printButtonTrans,
                    //   exportOptions: {
                    //     columns: ':visible'
                    //   }
                    // },
                    // {
                    //   extend: 'colvis',
                    //   className: 'btn-default',
                    //   text: colvisButtonTrans,
                    //   exportOptions: {
                    //     columns: ':visible'
                    //   }
                    // }
                ]
            });

            $.fn.dataTable.ext.classes.sPageButton = '';
        });

    </script>


    <script>

        Pusher.logToConsole = true;
        
        var pusher = new Pusher('772435f56d5bb1cd5565', {
        cluster: 'ap1'
        });

        var channel = pusher.subscribe('orders');

        let eventName = '';
        let env = "{{ config('app.env') }}";

        if(env == 'production'){
            eventName = 'live.order';
        }
        else if(env == 'staging'){
            eventName = 'order.staging.updated';
        }
        else{
            eventName = 'order.updated';
        }   

        channel.bind(eventName, function(data) {
            
            
            toastr.options.timeOut = 0;
            toastr.options.extendedTimeOut = 0;
            toastr.options.closeButton = true;
            toastr.success('<p>Order ID: ' + data.order.id + '</p><p>Status: ' 
                + data.order.status + '</p>' + '<p>Table: ' + data.order.table_top.code + '</p>'
                + '<p><strong>Print receipt for Kitchen </strong></p>');
       
        });
    </script>
    
    @yield('scripts')


    
</body>

</html>
