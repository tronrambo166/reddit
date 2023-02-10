

<!DOCTYPE HTML>
<head>
    <meta name="csrf_token" content="{{csrf_token()}}">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <title>Radit-@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"  />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css"  />

    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/style.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css')}}/custom.css">

</head>
<body>
<div class="container-fluid">

    @yield('page')


{{-- <div class="container-fluid px-0 ">


        <footer>
            <div class="row bg-dark fixed-bottom">
                <p class="m-auto font-italic text-light py-3">&copy; Copyright 2020. Radio Monitoring, All Rights Reserved</p>
            </div>
        </footer>

    </div> --}}
</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script>
<!-- Fluidify YT Video -->
<script src="https://unpkg.com/fluidify-video"></script>
<script src="{{asset('js')}}/main.js"></script>
@include('partials.notify')
@stack('script')



</body>
</html>
