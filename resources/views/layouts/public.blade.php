<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Portal Resmi Desa Maju Sejahtera - Sistem Informasi & Pelayanan Desa')">
    <meta name="keywords" content="desa maju sejahtera, pelayanan desa, informasi desa">
    <title>@yield('title', 'Desa Maju Sejahtera') | Portal Resmi Desa</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-link { transition: all 0.2s ease; }
        .nav-link:hover { color: #059669; }
        .nav-link.active { color: #059669; font-weight: 600; }
        .hero-gradient { background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 100%); }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
        .btn-primary { background: linear-gradient(135deg, #059669, #047857); transition: all 0.2s ease; }
        .btn-primary:hover { background: linear-gradient(135deg, #047857, #065f46); transform: translateY(-1px); box-shadow: 0 4px 15px rgba(5,150,105,0.4); }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.6s ease forwards; }
        .mobile-menu { display: none; }
        .mobile-menu.open { display: block; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-700 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <div class="font-bold text-emerald-800 text-sm leading-tight">Desa Maju Sejahtera</div>
                        <div class="text-xs text-gray-500">Kec. Nusantara Indah</div>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="nav-link px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 {{ request()->routeIs('home') ? 'active bg-emerald-50' : '' }}">Beranda</a>
                    <a href="{{ route('profile') }}" class="nav-link px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 {{ request()->routeIs('profile') ? 'active bg-emerald-50' : '' }}">Profil Desa</a>
                    <a href="{{ route('news.index') }}" class="nav-link px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 {{ request()->routeIs('news.*') ? 'active bg-emerald-50' : '' }}">Berita</a>
                    <a href="{{ route('events.index') }}" class="nav-link px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 {{ request()->routeIs('events.*') ? 'active bg-emerald-50' : '' }}">Agenda</a>
                    <a href="{{ route('services.index') }}" class="nav-link px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 {{ request()->routeIs('services.*') ? 'active bg-emerald-50' : '' }}">Layanan</a>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    <a href="{{ route('services.track') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-800 transition-colors">
                        Cek Status
                    </a>
                    @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Dashboard</span>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-600 transition-colors">Login Admin</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none" aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu md:hidden bg-white border-t border-gray-100">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : '' }}">🏠 Beranda</a>
                <a href="{{ route('profile') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('profile') ? 'bg-emerald-50 text-emerald-700' : '' }}">🏛️ Profil Desa</a>
                <a href="{{ route('news.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('news.*') ? 'bg-emerald-50 text-emerald-700' : '' }}">📰 Berita</a>
                <a href="{{ route('events.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('events.*') ? 'bg-emerald-50 text-emerald-700' : '' }}">📅 Agenda</a>
                <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 {{ request()->routeIs('services.*') ? 'bg-emerald-50 text-emerald-700' : '' }}">📋 Layanan</a>
                <a href="{{ route('services.track') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-emerald-600 hover:bg-emerald-50">🔍 Cek Status Pengajuan</a>
                <div class="pt-2 border-t border-gray-100">
                    @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium bg-emerald-600 text-white text-center">Dashboard Admin</a>
                    @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">Login Admin</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="fixed top-20 right-4 z-50 max-w-md" id="flash-success">
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-lg shadow-lg flex items-start space-x-3">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="flex-1">
                <p class="text-sm text-emerald-800 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('flash-success').remove()" class="text-emerald-400 hover:text-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-20 right-4 z-50 max-w-md" id="flash-error">
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-lg flex items-start space-x-3">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="flex-1">
                <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('flash-error').remove()" class="text-red-400 hover:text-red-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-emerald-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-emerald-700 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-white">Desa Maju Sejahtera</div>
                            <div class="text-emerald-400 text-xs">Kec. Nusantara Indah, Kab. Sejahtera Raya</div>
                        </div>
                    </div>
                    <p class="text-emerald-300 text-sm leading-relaxed mb-4">
                        Portal resmi Desa Maju Sejahtera. Menyediakan informasi desa, berita terkini, dan layanan administrasi untuk seluruh warga desa.
                    </p>
                    <div class="flex space-x-3">
                        <span class="bg-emerald-800 text-emerald-300 text-xs px-3 py-1 rounded-full">Transparan</span>
                        <span class="bg-emerald-800 text-emerald-300 text-xs px-3 py-1 rounded-full">Akuntabel</span>
                        <span class="bg-emerald-800 text-emerald-300 text-xs px-3 py-1 rounded-full">Melayani</span>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Menu Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-emerald-300 hover:text-white text-sm transition-colors">🏠 Beranda</a></li>
                        <li><a href="{{ route('profile') }}" class="text-emerald-300 hover:text-white text-sm transition-colors">🏛️ Profil Desa</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-emerald-300 hover:text-white text-sm transition-colors">📰 Berita Desa</a></li>
                        <li><a href="{{ route('events.index') }}" class="text-emerald-300 hover:text-white text-sm transition-colors">📅 Agenda Kegiatan</a></li>
                        <li><a href="{{ route('services.index') }}" class="text-emerald-300 hover:text-white text-sm transition-colors">📋 Layanan Masyarakat</a></li>
                        <li><a href="{{ route('services.track') }}" class="text-emerald-300 hover:text-white text-sm transition-colors">🔍 Cek Status Pengajuan</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Kontak</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-2">
                            <svg class="w-4 h-4 text-emerald-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-emerald-300 text-sm">Jl. Raya Desa No. 1, Kec. Nusantara Indah</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span class="text-emerald-300 text-sm">(0291) 123-4567</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="text-emerald-300 text-sm">info@desamajusejahtera.id</span>
                        </li>
                        <li class="mt-2">
                            <span class="text-emerald-400 text-xs">Jam Pelayanan:</span>
                            <p class="text-emerald-300 text-sm">Sen–Jum: 08.00–15.00 WIB</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-emerald-800 mt-8 pt-8 flex flex-col sm:flex-row justify-between items-center">
                <p class="text-emerald-400 text-sm">© {{ date('Y') }} Desa Maju Sejahtera. Hak Cipta Dilindungi.</p>
                <div class="flex items-center space-x-4 mt-4 sm:mt-0">
                    <a href="{{ route('health') }}" target="_blank" class="text-emerald-500 hover:text-emerald-300 text-xs transition-colors">System Health</a>
                    <a href="{{ route('login') }}" class="text-emerald-500 hover:text-emerald-300 text-xs transition-colors">Admin Login</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => menu.classList.toggle('open'));

        // Auto-dismiss flash messages
        setTimeout(() => {
            ['flash-success', 'flash-error'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.remove();
            });
        }, 5000);

        // Lucide icons
        lucide.createIcons();
    </script>

    @stack('scripts')
</body>
</html>
