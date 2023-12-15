@push('statis-css')
@endpush
<div class="top-section">
    <nav class="navbar custom-navbar navbar-expand-md">
        <div class="container">
            <a href="{{ route('frontend.index') }}" style="display:contents">
                <img src="{{ asset('img/Logo-Kemas.png') }}" class="navbar-brand" alt="logo-kemas">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="fas fa-bars"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto d-none d-md-flex">
                    <li class="nav-item active">
                        <a class="nav-link {{ Route::is('frontend.index') ? 'active' : '' }}"
                            href="{{ route('frontend.index') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(2) === 'berita' ? 'active' : '' }}"
                            href="{{ route('home.index_berita') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home.index_galeri') ? 'active' : '' }}"
                            href="{{ route('home.index_galeri') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home.index_tentang') ? 'active' : '' }}"
                            href="{{ route('home.index_tentang') }}">Tentang Kami</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="btn nav-link btn-nav-link" href="{{ route('frontend.auth.login') }}">Login</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <x-utils.link href="#" id="navbarDropdown"
                                class="btn nav-link btn-nav-link dropdown-toggle" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                <x-slot name="text">
                                    <img class="rounded-circle mr-2" style="max-height: 20px"
                                        src="{{ $logged_in_user->avatar }}" /> Hi,
                                    {{ $logged_in_user->name }}
                                    <span class="caret"></span>
                                </x-slot>
                            </x-utils.link>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                @if ($logged_in_user->isAdmin())
                                    <x-utils.link :href="route('admin.dashboard')" class="dropdown-item">
                                        <i class="fas fa-user-shield mr-2"></i>
                                        {{ __('Dashboard') }}
                                    </x-utils.link>
                                    <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        @lang('Keluar')
                                    </a>
                                    <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none">
                                        @csrf
                                    </x-forms.post>
                                @endif

                                @if ($logged_in_user->isUser())
                                    <x-utils.link :href="route('home.index_keluarga')" :active="activeClass(Route::is('home.index_keluarga'))" class="dropdown-item">
                                        <i class="fas fa-users mr-2"></i>
                                        {{ __('Keluargaku') }}
                                    </x-utils.link>

                                    <x-utils.link :href="route('home.index_surat')" :active="activeClass(Route::is('home.index_surat'))"
                                        class="{{ request()->segment(2) === 'surat' ? 'active' : '' }} dropdown-item">
                                        <i class="fas fa-envelope mr-2"></i>
                                        {{ __('Pengajuan Surat RT') }}
                                    </x-utils.link>
                                    <x-utils.link :href="route('home.index_pengajuan')" :active="activeClass(Route::is('home.index_pengajuan'))" class="dropdown-item">
                                        <i class="fas fa-file-contract mr-2"></i>
                                        {{ __('Daftar Pengajuanku') }}
                                    </x-utils.link>

                                    <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        @lang('Keluar')
                                    </a>
                                    <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none">
                                        @csrf
                                    </x-forms.post>
                                @endif
                            </div>
                        </li>
                    @endguest
                </ul>

                <ul class="navbar-nav ml-auto d-flex d-md-none">
                    <li class="nav-item active">
                        <a class="nav-link {{ Route::is('frontend.index') ? 'active' : '' }}"
                            href="{{ route('frontend.index') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home.index_berita') ? 'active' : '' }}"
                            href="{{ route('home.index_berita') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home.index_galeri') ? 'active' : '' }}"
                            href="{{ route('home.index_galeri') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home.index_tentang') ? 'active' : '' }}"
                            href="{{ route('home.index_tentang') }}">Tentang Kami</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="btn nav-link btn-nav-link" href="{{ route('frontend.auth.login') }}">Login</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <x-utils.link href="#" id="navbarDropdown"
                                class="btn nav-link btn-nav-link dropdown-toggle" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                <x-slot name="text">
                                    <img class="rounded-circle mr-2" style="max-height: 20px"
                                        src="{{ $logged_in_user->avatar }}" /> Hi,
                                    {{ $logged_in_user->name }}
                                    <span class="caret"></span>
                                </x-slot>
                            </x-utils.link>
                <ul class="navbar-nav ml-auto d-flex d-md-none">
                    <li class="nav-item active">
                        <a class="nav-link {{ Route::is('frontend.index') ? 'active' : '' }}"
                            href="{{ route('frontend.index') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home.index_berita') ? 'active' : '' }}"
                            href="{{ route('home.index_berita') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home.index_galeri') ? 'active' : '' }}"
                            href="{{ route('home.index_galeri') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home.index_tentang') ? 'active' : '' }}"
                            href="{{ route('home.index_tentang') }}">Tentang Kami</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="btn nav-link btn-nav-link" href="{{ route('frontend.auth.login') }}">Login</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <x-utils.link href="#" id="navbarDropdown"
                                class="btn nav-link btn-nav-link dropdown-toggle" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                <x-slot name="text">
                                    <img class="rounded-circle mr-2" style="max-height: 20px"
                                        src="{{ $logged_in_user->avatar }}" /> Hi,
                                    {{ $logged_in_user->name }}
                                    <span class="caret"></span>
                                </x-slot>
                            </x-utils.link>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if ($logged_in_user->isAdmin())
                                    <x-utils.link :href="route('admin.dashboard')" class="dropdown-item">
                                        <i class="fas fa-user-shield mr-2"></i>
                                        {{ __('Dashboard') }}
                                    </x-utils.link>
                                    <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        @lang('Keluar')
                                    </a>
                                    <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none">
                                        @csrf
                                    </x-forms.post>
                                @endif

                                @if ($logged_in_user->isUser())
                                    <x-utils.link :href="route('home.index_keluarga')" :active="activeClass(Route::is('home.index_keluarga'))" class="dropdown-item">
                                        <i class="fas fa-users mr-2"></i>
                                        {{ __('Keluargaku') }}
                                    </x-utils.link>

                                    <x-utils.link :href="route('home.index_surat')" :active="activeClass(Route::is('home.index_surat'))"
                                        class="{{ request()->segment(2) === 'surat' ? 'active' : '' }} dropdown-item">
                                        <i class="fas fa-envelope mr-2"></i>
                                        {{ __('Pengajuan Surat RT') }}
                                    </x-utils.link>
                                    <x-utils.link :href="route('home.index_pengajuan')" :active="activeClass(Route::is('home.index_pengajuan'))" class="dropdown-item">
                                        <i class="fas fa-file-contract mr-2"></i>
                                        {{ __('Daftar Pengajuanku') }}
                                    </x-utils.link>

                                    <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        @lang('Keluar')
                                    </a>
                                    <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none">
                                        @csrf
                                    </x-forms.post>
                                @endif
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @php
        $currentDate = Carbon\Carbon::now();
        $messages = App\Domains\Announcement\Models\Announcement::where('starts_at', '<=', $currentDate)
            ->where('ends_at', '>=', $currentDate)
            ->get();
    @endphp
    @if ($messages->count() == 1)
        @foreach ($messages as $announcement)
            <div class="alert @if ($announcement->type == 'info') alert-primary @else alert-danger @endif m-0 d-flex align-items-center justify-content-center"
                role="alert" id="announcement">
                <b>{!! $announcement->message !!}</b>
            </div>
        @endforeach
    @elseif ($messages->count() > 1)
        <div class="alert alert-info m-0 d-flex align-items-center justify-content-center" role="alert"
            id="announcement">
            <marquee behavior="scroll" direction="left">
                @foreach ($messages as $announcement)
                    <b>{!! strip_tags($announcement->message) !!}</b> &nbsp;|&nbsp;
                @endforeach
            </marquee>
        </div>
    @endif

</div>