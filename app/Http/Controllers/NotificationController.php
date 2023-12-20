<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function group($id)
    {
        $group = Group::find($id);
        $notif = "Pesan baru di group ".$group->name;
        return $notif;
    }
}
