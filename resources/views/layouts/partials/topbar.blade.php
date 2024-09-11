<nav class="navbar navbar-expand-lg main-navbar">
    <div class="mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li>
                <div class="nav-link nav-link-lg"><span id="time"></span></div>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg @if(Auth::user()->unreadNotifications->count() > 0) beep @endif"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifikasi
                    <div class="float-right">
                        <a href="#">Baca Semua</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    
                    @foreach (Auth::user()->unreadNotifications as $notif)
                        <a href="{{ $notif->data['url'].'?id='.$notif->id }}" class="dropdown-item">
                            <div class="dropdown-item-icon bg-info text-white">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ $notif->data['title'] }}
                                <p>{{ $notif->data['messages'] }}</p>
                                <div class="time">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</div>
                            </div>
                        </a>
                    @endforeach

                </div>
            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @if (Auth::user()->profile != null)
                    @if(Auth::user()->profile->foto <> '')
                        <img alt="image" src="{{ url(Auth::user()->profile->foto) }}" class="rounded-circle mr-1">
                    @else
                        <img alt="image" src="{{ url('images/avatar-5.png') }}" class="rounded-circle mr-1">
                    @endif
                @else
                    <img alt="image" src="{{ url('images/avatar-5.png') }}" class="rounded-circle mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('admin.administrator.edit', Auth::user()->id) }}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profil
                    </a>
                @elseif(Auth::user()->role == 'pelanggan')
                    <a href="{{ route('pelanggan.profile') }}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profil
                    </a>
                @elseif(Auth::user()->role == 'penjoki')
                    <a href="{{ route('penjoki.profile') }}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profil
                    </a>
                @endif

                <div class="dropdown-divider"></div>
                <a href="{{ route('logout', Auth::user()->role) }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </li>
    </ul>
</nav>
