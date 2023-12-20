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
<script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<!-- Page Specific JS File -->
{{-- <script src="{{ asset('assets/js/page/index.js') }}"></script> --}}
<script src="{{ asset('assets/js/page/features-post-create.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script>
    $(document).ready(function () {

        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', { cluster: 'ap1' });
        const channel = pusher.subscribe('public');

        channel.bind('chat', function (data) {
            var user_id = '{{ Auth::user()->id }}';

            if (user_id != data.message.user_id) {
                var url = "{{ url('notif/group/chat') }}/" + data.message.group_id;
                $.get(url, function (data) {
                    iziToast.success({
                        title: 'Success',
                        message: data,
                        position: 'topRight'
                    });
                });
            }
        });
        
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

    })
</script>

@endsection