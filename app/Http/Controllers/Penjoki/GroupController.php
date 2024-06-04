<?php

namespace App\Http\Controllers\Penjoki;

use App\Events\MessageBroadcast;
use App\Http\Controllers\Controller;
use App\Models\ChatGroup;
use App\Models\Group;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    // Menampilkan halaman group
    public function index()
    {
        $setting = Setting::first();

        $dataDeadline = Order::where('user_id', Auth::user()->id)->whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::where('user_id', Auth::user()->id)->whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $group = Group::where('penjoki_id', Auth::guard('penjoki')->user()->id)->orderBy('id', 'desc')->get();

        return view('joki.group.index', compact('setting', 'dataDeadline', 'dataDeadline2', 'group'));
    }

    // Menampilkan chat group
    public function chat($id)
    {
        $group = Group::find($id);
        $chatgroup = ChatGroup::where('group_id', $id)->get();

        $chat = array();
        foreach($chatgroup as $row) {

            $name = $row->user->name;
            if ($row->user->role == 'pelanggan') {
                $name = "Anonimous";
            }
            $time = Carbon::parse($row->created_at)->diffForHumans();

            if ($row->user->role == 'admin') {
                $picture = url('images/avatar-5.png');
            } else {
                if ($row->user->profile->foto <> '') {
                    $picture = url($row->user->profile->foto);
                } else {
                    $picture = url('images/avatar-2.png');
                }
            }

            $position = 'left';
            if ($row->user_id == Auth::guard('penjoki')->user()->id) {
                $position = 'right';
            }

            $chat[] = array(
                'name' => $name,
                'text' => $row->message,
                'picture' => $picture,
                'position' => $position,
                'time' => $time
            );
        }

        $data = array(
            'length' => ChatGroup::where('group_id', $id)->count(),
            'groupid' => $group->id,
            'title' => $group->name,
            'chat' => $chat
        );

        return $data;
    }

    // Proses Receive
    public function receive($id)
    {
        $chat = ChatGroup::find($id);

        $name = $chat->user->name;
        if ($chat->user->role == 'pelanggan') {
            $name = 'Anonimous';
        }
        $time = Carbon::parse($chat->created_at)->diffForHumans();

        if ($chat->user->role == 'admin') {
            $picture = url('images/avatar-5.png');
        } else {
            if ($chat->user->profile->foto <> '') {
                $picture = url($chat->user->profile->foto);
            } else {
                $picture = url('images/avatar-2.png');
            }
        }

        $position = 'left';

        $chat = array(
            'name' => $name,
            'text' => $chat->message,
            'picture' => $picture,
            'position' => $position,
            'time' => $time
        );

        return $chat;
    }

    // Proses chat
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $data = array(
                'status' => 'gagal',
                'error' => $errors->first('message')
            );
            return $data;
        } else {

            $chatgroup = new ChatGroup;
            $chatgroup->message = $request->message;
            $chatgroup->group_id = $request->group_id;
            $chatgroup->user_id = $request->user_id;
            $chatgroup->save();
            $chat_id = $chatgroup->id;
    
            $chat = ChatGroup::find($chat_id);

            broadcast(new MessageBroadcast($chat))->toOthers();
    
            $name = $chat->user->name;
            $time = Carbon::parse($chat->created_at)->diffForHumans();
    
            if ($chat->user->role == 'admin') {
                $picture = url('images/avatar-5.png');
            } else {
                if ($chat->user->profile->foto <> '') {
                    $picture = url($chat->user->profile->foto);
                } else {
                    $picture = url('images/avatar-2.png');
                }
            }
    
            $position = 'right';
    
            $data = array(
                'chat' => array(
                    'name' => $name,
                    'text' => $chat->message,
                    'picture' => $picture,
                    'position' => 'chat-'.$position,
                    'time' => $time
                ),
                'status' => 'berhasil'
            );
    
            return $data;
        }
    }
}
