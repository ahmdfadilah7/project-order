<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login - {{ $setting->nama_website }}</title>

    <!-- Favicon -->
    <link href="{{ url($setting->favicon) }}" rel="icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="{{ url($setting->logo) }}" alt="logo" width="100" class="shadow-light">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="text-center w-100">
                                    <h4>{{ $setting->nama_website }}</h4>
                                </div>
                            </div>

                            <div class="card-body">
                                @if($msg = Session::get('berhasil'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ $msg }}
                                        </div>
                                    </div>
                                @elseif ($msg = Session::get('gagal'))
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ $msg }}
                                        </div>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('prosesLogin') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus value="{{ old('email') }}">
                                        <i class="text-danger">{{ $errors->first('email') }}</i>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                        <i class="text-danger">{{ $errors->first('password') }}</i>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                                <div class="mt-2 text-center text-dark">
                                    Don't have an account? <a href="{{ route('register') }}">Create One</a>
                                </div>
                                <div class="simple-footer text-dark">
                                    Copyright &copy; {{ $setting->nama_website }} {{ date('Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/modules/izitoast/js/iziToast.min.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        @if (Session::has('berhasil'))
            iziToast.success({
                title: 'Success',
                message: '{{ session("berhasil") }}',
                position: 'topRight'
            });
        @endif

        @if (Session::has('errors'))
            @foreach ($errors->all() as $errors)                
                iziToast.error({
                    title: 'Error',
                    message: '{{ $errors }}',
                    position: 'topRight'
                });
            @endforeach
        @endif

        @if (Session::has('gagal'))            
            iziToast.error({
                title: 'Error',
                message: '{{ session("gagal") }}',
                position: 'topRight'
            });
        @endif
    </script>
</body>

</html>
