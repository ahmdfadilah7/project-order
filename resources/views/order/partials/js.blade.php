@section('js')

<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ asset('assets/modules/cleave-js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/modules/chart.min.js') }}"></script>
<script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
<script src="{{ asset('assets/modules/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<!-- Page Specific JS File -->
{{-- <script src="{{ asset('assets/js/page/index.js') }}"></script> --}}
<script src="{{ asset('assets/js/page/features-post-create.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script>
    function deleteModal(url) {
        var url = url;
        $('#staticBackdrop').modal('show');
        $('#btnDelete').attr('href', url)
    }

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

    @if(Auth::user()->role <> 'admin' && Auth::user()->role <> 'pelanggan')
    function deadline() {
        @foreach ($dataDeadline as $key => $row)
            @if ($row->status <> 2)
                @if ($row->activity <> '')
                    @if ($row->activity->status <> 1)
                        iziToast.warning({
                            title: 'Warning',
                            message: 'Tim {{ $row->user->name }} - Kode Klien {{ $row->kode_klien }} sudah Deadline',
                            position: 'topRight'
                        });
                    @endif
                @else
                    iziToast.warning({
                        title: 'Warning',
                        message: 'Tim {{ $row->user->name }} - Kode Klien {{ $row->kode_klien }} sudah Deadline',
                        position: 'topRight'
                    });
                @endif
            @endif
        @endforeach
    }
    deadline();
    setInterval(deadline, 60000);

    function deadline2() {
        @foreach ($dataDeadline2 as $key => $row)
            @if ($row->status <> 2)
                @if ($row->activity <> '')
                    @if ($row->activity->status <> 1)
                        iziToast.warning({
                            title: 'Warning',
                            message: 'Tim {{ $row->user->name }} - Kode Klien {{ $row->kode_klien }} sisa 1 hari lagi',
                            position: 'topRight'
                        });
                    @endif
                @else
                    iziToast.warning({
                        title: 'Warning',
                        message: 'Tim {{ $row->user->name }} - Kode Klien {{ $row->kode_klien }} sisa 1 hari lagi',
                        position: 'topRight'
                    });
                @endif
            @endif
        @endforeach
    }
    deadline2();
    setInterval(deadline2, 60000);
    @endif

    // Inside your Javascript file
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        var text = "Selamat Pagi {{ Auth::user()->name }}, Jadilah yang terbaik dari yang terbaik."
        if (h >= 12) {
            var text = "Selamat Siang {{ Auth::user()->name }}, Jangan lupa makan dan istirahat sejenak."
        } 
        if (h >= 15) {
            var text = "Selamat Sore {{ Auth::user()->name }}, Kebahagiaan itu ada, jika kamu mau menjemputnya."
        } 
        if (h >= 19) {
            var text = "Selamat Malam {{ Auth::user()->name }}, Seberat apapun hal yang dihadapi jangan pernah menyerah."
        }
        var emoji = "&#128513;"

        document.getElementById('time').innerHTML =
        h + ":" + m + " " + text + " " + emoji;
        var t = setTimeout(startTime, 500);
    }
    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }
    setInterval(startTime, 1000);
</script>

@endsection