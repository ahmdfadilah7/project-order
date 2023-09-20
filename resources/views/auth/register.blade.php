<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Pendaftaran - {{ $setting->nama_website }}</title>

    <!-- Favicon -->
    <link href="{{ url($setting->favicon) }}" rel="icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/admin/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/modules/fontawesome/css/all.min.css') }}">
    
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/admin/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/modules/izitoast/css/iziToast.min.css') }}">
    
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/components.css') }}">
    
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <img src="{{ url($setting->logo) }}" alt="logo" width="100" class="shadow-light">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="text-center w-100">
                                    <h4>Pendaftaran {{ $setting->nama_website }}</h4>
                                </div>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('prosesRegister') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" value="{{ old('nama_lengkap') }}">
                                        <i class="text-danger">{{ $errors->first('nama_lengkap') }}</i>
                                    </div>

                                    <div class="form-group">
                                        <label for="jns_kelamin">Jenis Kelamin</label>
                                        <select name="jns_kelamin" class="form-control selectric" id="jns_kelamin">
                                            <option value="">- Pilih -</option>
                                            <option value="L" @if(old('jns_kelamin') == 'L') selected @endif>Laki - Laki</option>
                                            <option value="P" @if(old('jns_kelamin') == 'P') selected @endif>Perempuan</option>
                                        </select>
                                        <i class="text-danger">{{ $errors->first('jns_kelamin') }}</i>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="tmpt_lahir">Tempat Lahir</label>
                                            <input type="text" name="tmpt_lahir" class="form-control" id="tmpt_lahir" value="{{ old('tmpt_lahir') }}">
                                            <i class="text-danger">{{ $errors->first('tmpt_lahir') }}</i>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" value="{{ old('tgl_lahir') }}">
                                            <i class="text-danger">{{ $errors->first('tgl_lahir') }}</i>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                                            <i class="text-danger">{{ $errors->first('email') }}</i>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="no_telp">No Telepon</label>
                                            <input type="number" name="no_telp" class="form-control" id="no_telp" value="{{ old('no_telp') }}">
                                            <i class="text-danger">{{ $errors->first('no_telp') }}</i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" class="form-control summernote-simple" id="alamat" rows="10">{{ old('alamat') }}</textarea>
                                        <i class="text-danger">{{ $errors->first('alamat') }}</i>
                                    </div>

                                    <div class="form-group">
                                        <label for="foto">Foto</label>
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">Choose File</label>
                                            <input type="file" name="image" id="image-upload" />
                                        </div>
                                        <i class="text-danger">{{ $errors->first('image') }}</i>
                                    </div>

                                    <div class="form-divider">
                                        Account
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}">
                                        <i class="text-danger">{{ $errors->first('username') }}</i>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password</label>
                                            <input type="password" name="password" class="form-control pwstrength" id="password" data-indicator="pwindicator">
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                            <i class="text-danger">{{ $errors->first('password') }}</i>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password2" class="d-block">Password Confirmation</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="password2">
                                            <i class="text-danger">{{ $errors->first('password') }}</i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Daftar
                                        </button>
                                    </div>
                                </form>
                                <div class="mt-2 text-center text-dark">
                                    I have an account? <a href="{{ route('login') }}">Sign In</a>
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
    <script src="{{ asset('assets/admin/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/admin/modules/cleave-js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/admin/js/page/features-post-create.js') }}"></script>
    <script src="{{ asset('assets/admin/js/page/auth-register.js') }}"></script>
    <script src="{{ asset('assets/admin/modules/izitoast/js/iziToast.min.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom.js') }}"></script>
    <script type="text/javascript">
        @if (Session::has('errors'))
            @foreach ($errors->all() as $errors)
            iziToast.error({
                title: 'Error',
                message: '{{ $errors }}',
                position: 'topRight'
            });
            @endforeach
        @endif
    </script>
</body>

</html>
