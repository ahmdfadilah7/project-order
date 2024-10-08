@extends('layouts.app')
@include('group.partials.css')
@include('group.partials.js')

@section('content')
    <div class="section-header">
        <h1>Group</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.group') }}">Group</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'route' => ['admin.group.store']]) !!}
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="">Nama Group</label>
                                    <input type="text" name="nama_group" class="form-control" placeholder="Nama Group" autocomplete="off">
                                    <i class="text-danger">{{ $errors->first('nama_group') }}</i>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label>Karyawan</label>
                                    <select name="karyawan" class="form-control select2">
                                        <option value="">- Pilih -</option>
                                        @foreach ($penjoki as $row)
                                            <option value="{{ $row->id }}" @if(old('karyawan')==$row->id) selected @endif>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="text-danger">{{ $errors->first('karyawan') }}</i>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Pelanggan</label>
                                    <select name="pelanggan" class="form-control select2">
                                        <option value="">- Pilih -</option>
                                        @foreach ($user as $row)
                                            <option value="{{ $row->id }}" @if(old('pelanggan')==$row->id) selected @endif>{{ $row->name.' - '.$row->profile->kode_klien }}</option>
                                        @endforeach
                                    </select>
                                    <i class="text-danger">{{ $errors->first('pelanggan') }}</i>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 pt-1">
                                <button type="submit" class="btn btn-success mt-4"><i class="fa fa-save"></i> Tambah</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Group</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border">

                        @foreach ($group as $row)
                            <li>
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0)" id="group-chat"
                                        data-url="{{ route('admin.group.chat', $row->id) }}" 
                                        data-groupid="{{ $row->id }}" class="media">
                                        <figure class="avatar mr-2 bg-warning text-white" data-initial="GP"></figure>
                                        <div class="media-body">
                                            <div class="mb-1 font-weight-bold d-flex">{{ $row->name }}</div>
                                            <div class="text-dark text-small font-600-bold" id="infoChat{{ $row->id }}">
                                                {{-- <i class="fas fa-circle"></i> Online --}}
                                                @php
                                                    $chat = App\Models\ChatGroup::where('group_id', $row->id)->latest('created_at')->first();
                                                    if ($chat <> '') {
                                                        if (strlen($chat->message) > 150) {
                                                            $message = substr($chat->message, 0, 200).'...';
                                                        } else {
                                                            $message = $chat->message;
                                                        }
                                                        echo $chat->user->name.': '.$message;
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                    </a>
                                    <a onclick="deleteModal('{{ route('admin.group.delete', $row->id) }}')" class="text-danger text-right"><i class="fas fa-trash"></i> Hapus</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-sm-12">
            <div class="card chat-box" id="mychatbox" style="display: none;">
                <div class="card-header d-flex">
                    <h4 id="titleboxchat"></h4>
                    <p id="membergroup"></p>
                </div>
                <div class="card-body chat-content">
                </div>
                <div class="card-footer chat-form">
                    {!! Form::open(['method' => 'post', 'id' => 'chat-form', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="group_id" id="groupId">
                        <textarea name="message" id="message" class="form-control summernote-chat"></textarea>
                        <i class="text-danger" id="message-error"></i>
                        <button type="submit" class="btn btn-primary">
                            <i class="far fa-paper-plane"></i>
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('group.partials.delete')
@endsection

@section('script')
    <script>

        $(document).ready(function() {

            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', { cluster: 'ap1' });
            const channel = pusher.subscribe('public');

            /* When click show user */
            $('body').on('click', '#group-chat', function() {
                var userURL = $(this).data('url');
                var groupID = $(this).data('groupid');
                $.get(userURL, function(data) {
                    $('#mychatbox .chat-content').empty();
                    document.getElementById('mychatbox').style.display = 'block';

                    $('#groupId').val(data.groupid);
                    $('#titleboxchat').html(data.title);
                    $('#membergroup').html(data.member);
                    var chats = data.chat;

                    for (var i = 0; i < chats.length; i++) {
                        var type = 'text';
                        if (chats[i].typing != undefined) type = 'typing';
                        $.chatCtrl('#mychatbox', {
                            role: '{{ Auth::user()->role }}',
                            id: (chats[i].id != undefined ? chats[i].id : ''),
                            name: (chats[i].name != undefined ? chats[i].name : ''),
                            text: (chats[i].text != undefined ? chats[i].text : ''),
                            picture: (chats[i].picture != undefined ? chats[i].picture : ''),
                            position: 'chat-' + chats[i].position,
                            time: (chats[i].time != undefined ? chats[i].time : ''),
                            type: type
                        });
                    }

                });

                channel.bind('chat', function (data) {
                    var url = "{{ url('admin/group/receive') }}/" + data.message.id
                    if (groupID == data.message.group_id) {
                        $.get(url, function (data) {
                            $.chatCtrl('#mychatbox', data);
                        });
                    }

                    var infoChatgroup = 'infoChat'+data.message.group_id
                    $.get(url, function (data) {
                        document.getElementById(infoChatgroup).innerHTML = data.name + ': ' + data.text2;
                    });
                });
            });

            $('#chat-form').on('submit', function(e) {
                e.preventDefault(); 
                var groupid = $('#groupId').val();
                var message = $('#message').val();
                var user_id = '{{ Auth::guard("admin")->user()->id }}'
                $.ajax({
                    type: "POST",
                    url: '{{ url('admin/group/chatadd') }}',
                    headers: {
                        'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: {
                        "_token": "{{ csrf_token() }}",
                        group_id:groupid, 
                        message:message,
                        user_id:user_id
                    },
                    success: function(data) {
                        if (data.status == 'berhasil') {
                            $.chatCtrl('#mychatbox', data.chat);
                            $('#message').summernote('code', '');
                            var infoChatgroup = 'infoChat'+ groupid
                            document.getElementById(infoChatgroup).innerHTML = data.chat.name + ': ' + data.chat.text2;
                            document.getElementById('message-error').style.display = 'none';
                        } else {
                            $('#message-error').text(data.error);
                        }
                    }
                });
            });

            
        });

        function deleteModal(url) {
            var url = url;
            $('#staticBackdrop').modal('show');
            $('#btnDelete').attr('href', url)
        }

        function deleteChatModal(id) {
            var idChat = id;
            $('#staticBackdrop').modal('show');
            $('#btnDelete').attr('href', '{{ url("admin/group/chat/delete") }}/'+id)
        }
    </script>
@endsection
