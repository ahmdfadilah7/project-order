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

    public function __construct($dari, $sampai)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    public function view() : View 
    {
        $setting = Setting::first();
        
        $order = Order::where('deadline', '>=', $this->dari)
            ->where('deadline', '<=', $this->sampai)
            ->get();

        return view('order.excel', compact('setting', 'order'));
    }
}
