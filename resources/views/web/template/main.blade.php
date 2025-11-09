<!doctype html>
<html lang="en" style="visibility:hidden">

<head>
    <!-- ⚡ Instant Apply dari LocalStorage -->
    <script>
        (function() {
            const html = document.documentElement;
            const s = {
                themeMode: localStorage.getItem("themeMode") || "light",
                dirMode: localStorage.getItem("dirMode") || "ltr",
                colorTheme: localStorage.getItem("colorTheme") || "Orange_Theme",
                layoutMode: localStorage.getItem("layoutMode") || "vertical",
                boxedMode: localStorage.getItem("boxedMode") || "full",
                cardMode: localStorage.getItem("cardMode") || "shadow",
            };
            html.setAttribute("data-theme", s.themeMode);
            html.setAttribute("data-bs-theme", s.themeMode);
            html.setAttribute("dir", s.dirMode);
            html.setAttribute("data-color-theme", s.colorTheme);
            html.setAttribute("data-layout", s.layoutMode);
            html.setAttribute("data-boxed-layout", s.boxedMode);
            html.setAttribute("data-card", s.cardMode);
            // buat terlihat hanya setelah semua attribute diterapkan
            html.style.visibility = "visible";
        })();
    </script>

    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') . (isset($title_top) ? $title_top : '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="Notaris APP" name="description" />
    <meta content="Notaris APP" name="author" />
    <meta name="user-id" content="{{ Session::get('user_id') }}">

    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/loader/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />

    <style>
        .wd-column {
            width: 200px !important;
        }
    </style>


    {{-- loader --}}
    <link rel="stylesheet" href="{{ asset('assets/css/loader/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">

    @if (isset($header_data))
        @php $version = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'); @endphp
        @foreach ($header_data as $key => $v_head)
            @php $data_key = explode('-', $key); @endphp
            @if ($data_key[0] == 'css')
                <link rel="stylesheet" href="{{ $v_head }}?v={{ $version }}">
            @endif
        @endforeach
    @endif
</head>

<body>
    <div class="loader"></div>
    <!-- Loader -->
    <div class="preloader">
        <img src="{{ asset('assets/images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>

    <div id="main-wrapper">
        @include('web.template.leftmenu')
        <div class="page-wrapper">
            @include('web.template.header')
            <div class="body-wrapper">
                <div class="container-fluid">
                    {{-- @include('web.template.breadecumb') --}}
                    {!! $view_file !!}
                    @include('web.template.footer')
                </div>
            </div>
            @include('web.template.rightmenu')
        </div>
    </div>

    <div class="dark-transparent sidebartoggler"></div>

    <!-- JS Files -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>

    <!-- highlight.js -->
    <script src="{{ asset('assets/js/highlights/highlight.min.js') }}"></script>
    <script>
        hljs.initHighlightingOnLoad();
        document.querySelectorAll("pre.code-view > code").forEach((codeBlock) => {
            codeBlock.textContent = codeBlock.innerHTML;
        });
    </script>

    <script src="{{ asset('assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>


    {{--  --}}
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/utils/url.js') }}"></script>
    <script src="{{ asset('assets/utils/message.js') }}"></script>
    {{-- <script src="{{ asset('assets/utils/validation.js') }}"></script> --}}

    <script src="{{ asset('assets/js/plugins/bootstrap-validation-init.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js') }}"></script>


    <script src="{{ asset('assets/js/controllers/auth.js') }}"></script>
    <script src="{{ asset('assets/js/controllers/token.js') }}"></script>

    @if (isset($header_data))
        @php $version = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'); @endphp
        @foreach ($header_data as $key => $v_head)
            @php $data_key = explode('-', $key); @endphp
            @if ($data_key[0] == 'js')
                <script src="{{ $v_head }}?v={{ $version }}"></script>
            @endif
        @endforeach
    @endif

    <!-- 🌗 Simpan Settingan -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const html = document.documentElement;

            // ✅ Fungsi bantu: simpan & apply
            function setAndApply(key, value, attr) {
                localStorage.setItem(key, value);
                html.setAttribute(attr, value);
            }

            // === THEME (LIGHT/DARK) ===
            document.querySelector("#light-layout")?.addEventListener("click", () => {
                setAndApply("themeMode", "light", "data-theme");
                html.setAttribute("data-bs-theme", "light");
            });

            document.querySelector("#dark-layout")?.addEventListener("click", () => {
                setAndApply("themeMode", "dark", "data-theme");
                html.setAttribute("data-bs-theme", "dark");
            });

            // === DIRECTION ===
            document.querySelector("#ltr-layout")?.addEventListener("click", () => {
                setAndApply("dirMode", "ltr", "dir");
            });

            document.querySelector("#rtl-layout")?.addEventListener("click", () => {
                setAndApply("dirMode", "rtl", "dir");
            });

            // === COLOR THEME ===
            window.handleColorTheme = (theme) => {
                setAndApply("colorTheme", theme, "data-color-theme");
            };

            // === LAYOUT TYPE ===
            document.querySelector("#vertical-layout")?.addEventListener("click", () => {
                setAndApply("layoutMode", "vertical", "data-layout");
            });

            document.querySelector("#horizontal-layout")?.addEventListener("click", () => {
                setAndApply("layoutMode", "horizontal", "data-layout");
            });

            // === BOXED / FULL ===
            document.querySelector("#boxed-layout")?.addEventListener("click", () => {
                setAndApply("boxedMode", "boxed", "data-boxed-layout");
            });

            document.querySelector("#full-layout")?.addEventListener("click", () => {
                setAndApply("boxedMode", "full", "data-boxed-layout");
            });

            // === CARD STYLE ===
            document.querySelector("#card-with-border")?.addEventListener("click", () => {
                setAndApply("cardMode", "border", "data-card");
            });

            document.querySelector("#card-without-border")?.addEventListener("click", () => {
                setAndApply("cardMode", "shadow", "data-card");
            });

            // ✅ Setelah semua atribut terpasang → tampilkan halaman
            html.style.visibility = "visible";
        });
    </script>

</body>

</html>
