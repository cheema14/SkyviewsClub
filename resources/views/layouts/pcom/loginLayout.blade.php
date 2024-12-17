<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ trans('panel.site_title') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/pcomstyles.css') }}" >
</head>
<body>
    <div class=" custom-view-fluid">
            <div class="login-container-revised">
                <div class="row h-100">
                    <div class="col-lg-6 p-0 h-100 login-left-side text-white">
                    <footer class="footer mt-2">
                    <img src="{{ asset('img/pcom/PITB.png') }}" class="pitb-logo" alt="">
                    <p class="title mb-0">Powered by Punjab Information Technology Board</p>
                </footer>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center justify-content-center h-100 bg-white custom-border-radius">
                        <div class="login-content d-flex align-items-center justify-content-center flex-column">
                            <img class="login_screen" src="{{ asset('img/pcom/logo-bk.svg') }}" alt="" style="width: 170px;">
                            <div class="mb-0 lc-desc">Welcome to <span>PCOM</span></div>

                                @yield("content")
                            
                        </div>
                    </div>
                </div>
            </div>
               
    </div>
    @yield('scripts')
</body>

</html>
