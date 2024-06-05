<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ url($setting->logo) }}" class="mt-3 pb-2" width="150">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}"><img src="{{ url($setting->logo) }}" width="50"></a>
        </div>
        <ul class="sidebar-menu">

            @if(Auth::user()->role == 'admin')

                <li class="menu-header">Dashboard</li>
                <li @if(Request::segment(2)=='dashboard') class="active" @endif><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

                <li class="menu-header">Transaksi</li>
                <li @if(Request::segment(2)=='order' && Request::segment(3)=='') class="active" @endif><a class="nav-link" href="{{ route('admin.order') }}"><i class="fas fa-clipboard"></i> <span>Order</span></a></li>
                <li @if(Request::segment(2)=='order' && Request::segment(3)=='dataselesai') class="active" @endif><a class="nav-link" href="{{ route('admin.order.dataselesai') }}"><i class="fas fa-clipboard"></i> <span>Order Selesai</span></a></li>

                <li class="menu-header">Chatting</li>
                <li @if(Request::segment(2)=='group') class="active" @endif><a class="nav-link" href="{{ route('admin.group') }}"><i class="ion ion-chatbubbles"></i> <span>Group</span></a></li>

                @if(Auth::user()->access->access <> 'Admin QC')
                
                    <li class="menu-header">Page</li>
                    {{-- <li @if(Request::segment(2)=='project') class="active" @endif><a class="nav-link" href="{{ route('admin.project') }}"><i class="fas fa-file"></i> <span>Project</span></a></li> --}}
                    <li @if(Request::segment(2)=='bobot') class="active" @endif><a class="nav-link" href="{{ route('admin.bobot') }}"><i class="fas fa-file"></i> <span>Bobot Order</span></a></li>
                    <li @if(Request::segment(2)=='jenis') class="active" @endif><a class="nav-link" href="{{ route('admin.jenis') }}"><i class="fas fa-file"></i> <span>Jenis Order</span></a></li>

                    <li class="menu-header">Management User</li>
                    <li @if(Request::segment(2)=='penjoki') class="active" @endif><a class="nav-link" href="{{ route('admin.penjoki') }}"><i class="fas fa-users"></i> <span>Karyawan</span></a></li>
                    <li @if(Request::segment(2)=='pelanggan') class="active" @endif><a class="nav-link" href="{{ route('admin.pelanggan') }}"><i class="fas fa-users"></i> <span>Pelanggan</span></a></li>

                    @if(Auth::user()->access->access == 'Super Admin' || Auth::user()->access->access == 'Manajer')
                        <li @if(Request::segment(2)=='administrator') class="active" @endif><a class="nav-link" href="{{ route('admin.administrator') }}"><i class="fas fa-users"></i> <span>Manajemen</span></a></li>
                    @endif

                    <li class="menu-header">Settings</li>
                    <li @if(Request::segment(2)=='setting') class="active" @endif><a href="{{ route('admin.setting') }}" class="nav-link"><i class="fas ion-ios-gear"></i> <span>Setting Website</span></a></li>
                    
                @endif


            @elseif(Auth::user()->role == 'penjoki')

                <li class="menu-header">Dashboard</li>
                <li @if(Request::segment(2)=='dashboard') class="active" @endif><a class="nav-link" href="{{ route('penjoki.dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

                <li class="menu-header">Transaksi</li>
                <li @if(Request::segment(2)=='order') class="active" @endif><a class="nav-link" href="{{ route('penjoki.order') }}"><i class="fas fa-clipboard"></i> <span>Order</span></a></li>

                <li class="menu-header">Chatting</li>
                <li @if(Request::segment(2)=='group') class="active" @endif><a class="nav-link" href="{{ route('penjoki.group') }}"><i class="ion ion-chatbubbles"></i> <span>Group</span></a></li>
            
            @elseif(Auth::user()->role == 'pelanggan')

                <li class="menu-header">Dashboard</li>
                <li @if(Request::segment(2)=='dashboard') class="active" @endif><a class="nav-link" href="{{ route('pelanggan.dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

                <li class="menu-header">Transaksi</li>
                <li @if(Request::segment(2)=='order') class="active" @endif><a class="nav-link" href="{{ route('pelanggan.order') }}"><i class="fas fa-clipboard"></i> <span>Order</span></a></li>

                <li class="menu-header">Chatting</li>
                <li @if(Request::segment(2)=='group') class="active" @endif><a class="nav-link" href="{{ route('pelanggan.group') }}"><i class="ion ion-chatbubbles"></i> <span>Group</span></a></li>

            @endif

        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout', Auth::user()->role) }}" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </aside>
</div>
