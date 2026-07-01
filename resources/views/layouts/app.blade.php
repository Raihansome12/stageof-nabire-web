<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Stasiun Geofisika Kelas III Nabire')</title>
    <meta name="description" content="Website resmi Stasiun Geofisika Kelas III Nabire - BMKG" />

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('img/bmkg-logo.png') }}" type="image/png" />
    <link rel="shortcut icon" href="{{ asset('img/bmkg-logo.png') }}" type="image/png" />

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
                    <img src="{{ asset('img/bmkg-logo.png') }}" alt="BMKG" class="h-12 w-12 object-contain" />
                    <div>
                        <div class="font-heading text-bmkg-black font-bold text-sm leading-tight uppercase tracking-wide">
                            Stasiun Geofisika Kelas III Nabire
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">CERMAT</div>
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
                        {{-- Interactive Map Embed --}}
                        <div class="w-full sm:w-44 h-28 bg-white/10 rounded-xl overflow-hidden shrink-0 flex items-center justify-center">
                            <iframe 
                                src="https://maps.google.com/maps?q=-3.3763741257122364,135.4731676270848&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                                class="w-full h-full border-0" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
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

                    <div class="mt-8 flex items-center space-x-6 text-white/40">
                        <a href="https://www.instagram.com/stageofnabire/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://x.com/StaGeofNabire" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">
                            <span class="sr-only">X</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z" />
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/StaGeofNabire" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/@stasiungeofisikanabire3346" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">
                            <span class="sr-only">YouTube</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
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

        if (menuBtn && mobileMenu && iconOpen && iconClose) {
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
        }
    </script>

    @stack('scripts')
</body>
</html>