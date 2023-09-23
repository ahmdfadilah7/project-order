<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $setting->nama_website }}</title>

    <!-- Favicon -->
    <link href="{{ url($setting->favicon) }}" rel="icon">
    
    @yield('script_css')

    {{-- CSS --}}
    @yield('css')
    {{-- End CSS --}}

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            {{-- Topbar --}}
            @include('layouts.partials.topbar')
            {{-- End Topbar --}}

            {{-- Sidebar --}}
            @include('layouts.partials.sidebar')
            {{-- End Sidebar --}}

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">

                    {{-- Content --}}
                    @yield('content')
                    {{-- End Content --}}

                </section>
            </div>

            {{-- Footer --}}
            @include('layouts.partials.footer')
            {{-- End Footer --}}

        </div>
    </div>

    {{-- Javascript --}}
    @yield('js')
    {{-- End Javascript --}}

    {{-- Add Javascript --}}
    @yield('script')
    {{-- End Add Javascript --}}

</body>

</html>
