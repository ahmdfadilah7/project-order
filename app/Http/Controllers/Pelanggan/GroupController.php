<?php

namespace App\Http\Controllers\Pelanggan;

use App\Events\MessageBroadcast;
use App\Http\Controllers\Controller;
use App\Models\ChatGroup;
use App\Models\Group;
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

        $group = Group::where('pelanggan_id', Auth::guard('pelanggan')->user()->id)->orderBy('id', 'desc')->get();

        return view('customer.group.index', compact('setting', 'group'));
    }

    // Menampilkan chat group
    public function chat($id)
    {
        $group = Group::find($id);
        $chatgroup = ChatGroup::where('group_id', $id)->get();

        $chat = array();
        foreach($chatgroup as $row) {

            if ($row->user->role == 'pelanggan') {
                $name = $row->user->name." - Klien";
            } elseif ($row->user->role == 'penjoki') {
                $name = $row->user->name." - Tim";
            } elseif ($row->user->role == 'admin') {
                $name = $row->user->name.' - '.$row->user->access->access;
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
            if ($row->user_id == Auth::guard('pelanggan')->user()->id) {
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

        if ($chat->user->role == 'pelanggan') {
            $name = $chat->user->name.' - Klien';
        } elseif ($chat->user->role == 'penjoki') {
            $name = $chat->user->name.' - Tim';
        } elseif ($chat->user->role == 'admin') {
            $name = $chat->user->name.' - '.$chat->user->access->access;
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

        if (strlen($chat->message) > 150) {
            $message = substr($chat->message, 0, 200).'...';
        } else {
            $message = $chat->message;
        }

        $position = 'left';

        $chat = array(
            'name' => $name,
            'text' => $chat->message,
            'text2' => $message,
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

            if (strlen($chat->message) > 150) {
                $message = substr($chat->message, 0, 200).'...';
            } else {
                $message = $chat->message;
            }
    
            $position = 'right';
    
            $data = array(
                'chat' => array(
                    'name' => $name,
                    'text' => $chat->message,
                    'text2' => $message,
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
