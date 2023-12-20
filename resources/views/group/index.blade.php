@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')
    <div class="section-header">
        <h1>Group</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.group') }}">Group</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>Group</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border">

                        @foreach ($group as $row)
                            <li>
                                <a href="javascript:void(0)" id="group-chat"
                                    data-url="{{ route('admin.group.chat', $row->id) }}" class="media">
                                    <figure class="avatar mr-2 bg-warning text-white" data-initial="GP"></figure>
                                    <div class="media-body">
                                        <div class="mt-2 mb-1 font-weight-bold">{{ $row->name }}</div>
                                        {{-- <div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i> Online
                                    </div> --}}
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-sm-12">
            <div class="card chat-box" id="mychatbox" style="display: none;">
                <div class="card-header">
                    <h4 id="titleboxchat"></h4>
                </div>
                <div class="card-body chat-content">
                </div>
                <div class="card-footer chat-form">
                    {!! Form::open(['method' => 'post', 'id' => 'chat-form', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="group_id" id="groupId">
                        <input type="text" name="message" id="message" class="form-control" placeholder="Type a message" autocomplete="off">
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

@section('script')
    <script>
        $(document).ready(function() {

            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', { cluster: 'ap1' });
            const channel = pusher.subscribe('public');

            /* When click show user */
            $('body').on('click', '#group-chat', function() {
                var userURL = $(this).data('url');
                $.get(userURL, function(data) {
                    document.getElementById('mychatbox').style.display = 'block';

                    $('#groupId').val(data.groupid);
                    $('#titleboxchat').html(data.title);
                    var chats = data.chat;

                    for (var i = 0; i < chats.length; i++) {
                        var type = 'text';
                        if (chats[i].typing != undefined) type = 'typing';
                        $.chatCtrl('#mychatbox', {
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
                    $.get(url, function (data) {
                        $.chatCtrl('#mychatbox', data);
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
                            $('#message').val('');
                            document.getElementById('message-error').style.display = 'none';
                        } else {
                            $('#message-error').text(data.error);
                        }
                    }
                });
            });

        });
    </script>
@endsection
