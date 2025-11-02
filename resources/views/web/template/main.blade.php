<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') . isset($title_top) ? $title_top : '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="Notaris APP" name="description" />
    <meta content="Notaris APP" name="author" />
    <meta name="user-id" content="{{ Session::get('user_id') }}">
    <style>
        .wd-column {
            width: 200px !important;
        }
    </style>
    <!-- App favicon -->
    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    {{-- loader --}}
    <link rel="stylesheet" href="{{ asset('assets/css/loader/loader.css') }}">
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />


    <!-- Fonts & Icon -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    @if (isset($header_data))
        @php
            $version = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz');
        @endphp
        @foreach ($header_data as $key => $v_head)
            @php
                $data_key = explode('-', $key);
            @endphp
            @if ($data_key[0] == 'css')
                <link rel="stylesheet" href="{{ $v_head }}?v={{ $version }}">
            @endif
        @endforeach
    @endif
</head>

<body>
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('assets/images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <!-- Sidebar Start -->
        @include('web.template.leftmenu')
        <!--  Sidebar End -->
        <div class="page-wrapper">
            @include('web.template.header')

            <div class="body-wrapper">
                <div class="container-fluid">
                    @include('web.dashboard.index')
                </div>
            </div>
            @include('web.template.rightmenu')
        </div>

    </div>
    <div class="dark-transparent sidebartoggler"></div>

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- Import Js Files -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>



    <!-- highlight.js (code view) -->
    <script src="{{ asset('assets/js/highlights/highlight.min.js') }}"></script>
    <script>
        hljs.initHighlightingOnLoad();


        document.querySelectorAll("pre.code-view > code").forEach((codeBlock) => {
            codeBlock.textContent = codeBlock.innerHTML;
        });
    </script>
    <script src="{{ asset('assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards/dashboard.js') }}"></script>
</body>


@if (isset($header_data))
    @php
        $version = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz');
    @endphp
    @foreach ($header_data as $key => $v_head)
        @php
            $data_key = explode('-', $key);
        @endphp
        @if ($data_key[0] == 'js')
            <script src="{{ $v_head }}?v={{ $version }}"></script>
        @endif
    @endforeach
@endif
</body>

</html>
