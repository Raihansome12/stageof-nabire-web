<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Stasiun Geofisika Kelas III Nabire')</title>
    <meta name="description" content="Website resmi Stasiun Geofisika Kelas III Nabire - BMKG" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bmkg-lightblue min-h-screen flex flex-col">

    {{-- Top Bar --}}
    <div class="bg-white border-b border-gray-100 text-sm text-gray-500 px-4 py-1.5 text-right">
        <span id="live-date"></span>
        &ndash;
        <span id="live-clock" class="font-bold text-green-600"></span> WIT
    </div>

    {{-- Navbar --}}
    <header class="bg-white border-b-2 border-blue-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('img/bmkg-logo.png') }}" alt="BMKG" class="h-10 w-10 object-contain" />
                    <div>
                        <div class="font-heading text-bmkg-black font-bold text-sm leading-tight uppercase tracking-wide">
                            Stasiun Geofisika Kelas III Nabire
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">Motto</div>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <nav class="hidden lg:flex items-center gap-1">
                    @php
                        $navItems = [
                            ['route' => 'profil',               'label' => 'Profil'],
                            ['route' => 'publikasi',            'label' => 'Publikasi'],
                            ['route' => 'gempa-bumi',           'label' => 'Gempa Bumi'],
                            ['route' => 'informasi-geofisika',  'label' => 'Informasi Geofisika'],
                            ['route' => 'informasi-publik',     'label' => 'Informasi Publik'],
                            ['route' => 'layanan-masyarakat',   'label' => 'Layanan Masyarakat'],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           class="px-3 py-2 text-sm font-medium rounded-md transition-colors
                                  {{ request()->routeIs($item['route'])
                                       ? 'text-bmkg-blue bg-bmkg-lightblue font-semibold'
                                       : 'text-gray-600 hover:text-bmkg-blue hover:bg-bmkg-lightblue' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                {{-- Mobile Hamburger --}}
                <button id="menu-btn" class="lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100"
                        aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menu-icon-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path id="menu-icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden lg:hidden pb-3">
                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="block px-4 py-2.5 text-sm font-medium rounded-md mb-1 transition-colors
                              {{ request()->routeIs($item['route'])
                                   ? 'text-bmkg-blue bg-bmkg-lightblue font-semibold'
                                   : 'text-gray-600 hover:text-bmkg-blue hover:bg-bmkg-lightblue' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-bmkg-blue text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">

                {{-- Left: Identity --}}
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('img/bmkg-logo.png') }}" alt="BMKG"
                             class="h-12 w-12 object-contain p-1" />
                        <div class="font-heading font-bold text-xl leading-tight">
                            Stasiun Geofisika Kelas III Nabire
                        </div>
                    </div>
                    <div class="w-full border-t border-white/20 mb-4"></div>

                    <div class="flex flex-col sm:flex-row gap-6 items-start">
                        {{-- Map placeholder --}}
                        <div class="w-full sm:w-44 h-28 bg-white/10 rounded-xl overflow-hidden shrink-0 flex items-center justify-center">
                            <img src="{{ asset('img/footer-map.png') }}" alt="Lokasi"
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"/>
                            <div class="hidden w-full h-full bg-gradient-to-br from-green-800 to-green-600 items-center justify-center text-xs text-white/70">
                                📍 Nabire, Papua
                            </div>
                        </div>

                        <div class="text-sm text-white/80 space-y-2">
                            <p>JFFF+C6H, Jl. Matoa, Kalibobo, Distrik Nabire,<br>Kabupaten Nabire, Papua Tengah 98818</p>
                            <p>
                                <a href="mailto:stageof.nabire@bmkg.go.id"
                                   class="hover:text-white underline underline-offset-2">
                                    stageof.nabire@bmkg.go.id
                                </a>
                            </p>
                            <div class="pt-1">
                                <p class="font-semibold text-white text-xs uppercase tracking-wider mb-1">
                                    Layanan Pengaduan dan Informasi
                                </p>
                                <a href="https://wa.me/6282190796122" target="_blank"
                                   class="hover:text-white text-white/90">
                                    +62 82190796122 (WhatsApp)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Related Links --}}
                <div class="shrink-0">
                    <h4 class="font-heading font-bold text-sm uppercase tracking-widest text-white/60 mb-4">
                        Link Terkait
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="https://www.bmkg.go.id" target="_blank"
                               class="text-sm text-white/80 hover:text-white transition-colors">BMKG</a></li>
                        <li><a href="https://inatews.bmkg.go.id" target="_blank"
                               class="text-sm text-white/80 hover:text-white transition-colors">InaTEWS</a></li>
                        <li><a href="https://inatews.bmkg.go.id/wrs/index.html" target="_blank"
                               class="text-sm text-white/80 hover:text-white transition-colors">WRS</a></li>
                    </ul>

                    <p class="mt-8 text-xs text-white/40">
                        *Instagram, X, Facebook, YouTube SVG Icon Logo
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 text-center py-3 text-xs text-white/40">
            &copy; {{ date('Y') }} Stasiun Geofisika Kelas III Nabire &mdash; BMKG
        </div>
    </footer>

    {{-- Scripts --}}
    <script>
        // Live clock in WIT (UTC+9)
        function updateClock() {
            const now = new Date();
            const witOffset = 9 * 60;
            const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            const wit = new Date(utc + (60000 * witOffset));

            const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const months = ['Januari','Februari','Maret','April','Mei','Juni',
                            'Juli','Agustus','September','Oktober','November','Desember'];

            const dayName  = days[wit.getDay()];
            const date     = wit.getDate();
            const month    = months[wit.getMonth()];
            const year     = wit.getFullYear();
            const hh       = String(wit.getHours()).padStart(2,'0');
            const mm       = String(wit.getMinutes()).padStart(2,'0');
            const ss       = String(wit.getSeconds()).padStart(2,'0');

            document.getElementById('live-date').textContent = `${dayName}, ${date} ${month} ${year}`;
            document.getElementById('live-clock').textContent = `${hh} : ${mm} : ${ss}`;
        }
        updateClock();
        setInterval(updateClock, 1000);

        // Mobile menu toggle
        const menuBtn  = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen  = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');

        menuBtn.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.contains('open');
            if (isOpen) {
                mobileMenu.classList.remove('open');
                mobileMenu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            } else {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('open');
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>