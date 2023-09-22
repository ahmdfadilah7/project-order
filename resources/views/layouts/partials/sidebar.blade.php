<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ url($setting->logo) }}" width="50">
                <p>{{ $setting->nama_website }}</p>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}"><img src="{{ url($setting->logo) }}" width="50"></a>
        </div>
        <ul class="sidebar-menu">
            
            @if(Auth::user()->role == 'admin')

                <li class="menu-header">Dashboard</li>
                <li @if(Request::segment(2)=='dashboard') class="active" @endif><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

                <li class="menu-header">Page</li>
                <li @if(Request::segment(2)=='penjoki') class="active" @endif><a class="nav-link" href="{{ route('admin.penjoki') }}"><i class="fas fa-users"></i> <span>Penjoki</span></a></li>
                
                <li class="menu-header">Settings</li>
                <li @if(Request::segment(2)=='setting') class="active" @endif><a href="{{ route('admin.setting') }}" class="nav-link"><i class="fas ion-ios-gear"></i> <span>Setting Website</span></a></li>

            @elseif(Auth::user()->role == 'penjoki')

                <li class="menu-header">Dashboard</li>
                <li @if(Request::segment(2)=='dashboard') class="active" @endif><a class="nav-link" href="{{ route('petani.dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>                

            @endif

        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout', Auth::user()->role) }}" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </aside>
</div>
