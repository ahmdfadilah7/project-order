<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrderExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public $dari;
    public $sampai;
    public $status;

    public function __construct($dari, $sampai, $status)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
        $this->status = $status;
    }

    public function view() : View 
    {
        $setting = Setting::first();
        
        if (Auth::user()->role == 'penjoki') {
            $order = Order::where('user_id', Auth::user()->id)
                ->whereDate('created_at', '>=', $this->dari)
                ->whereDate('created_at', '<=', $this->sampai)
                ->get();

            $ordercount = Order::where('user_id', Auth::user()->id)
                ->whereDate('created_at', '>=', $this->dari)
                ->whereDate('created_at', '<=', $this->sampai)
                ->count();

            $dari = $this->dari;
            $sampai = $this->sampai;

            return view('joki.order.excel', compact('setting', 'order', 'ordercount', 'dari', 'sampai'));
        } else {

            if ($this->status <> '') {
                $order = Order::whereDate('created_at', '>=', $this->dari)
                    ->whereDate('created_at', '<=', $this->sampai)
                    ->where('status', $this->status)
                    ->get();
            } else {
                $order = Order::whereDate('created_at', '>=', $this->dari)
                    ->whereDate('created_at', '<=', $this->sampai)
                    ->get();
            }

            $dari = $this->dari;
            $sampai = $this->sampai;

            return view('order.excel', compact('setting', 'order', 'dari', 'sampai'));
        }

    }
}
