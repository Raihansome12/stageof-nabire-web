<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Admin — Stasiun Geofisika Nabire</title>
    <link rel="icon" href="{{ asset('img/bmkg-logo.png') }}" type="image/png" />
    <link rel="shortcut icon" href="{{ asset('img/bmkg-logo.png') }}" type="image/png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bmkg-lightblue min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <img src="{{ asset('img/bmkg-logo.png') }}" alt="BMKG" class="h-16 w-16 object-contain mx-auto mb-4"/>
            <h1 class="font-bold text-bmkg-blue text-xl">Stasiun Geofisika Kelas III Nabire</h1>
            <p class="text-gray-500 text-sm mt-1">Masuk ke Panel Administrator</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent transition-shadow"
                           placeholder="admin@bmkg.go.id"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent transition-shadow"
                           placeholder="••••••••"/>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue"/>
                    <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
                </div>
                <button type="submit"
                        class="w-full bg-bmkg-blue text-white font-semibold py-2.5 rounded-lg text-sm hover:opacity-90 transition-opacity">
                    Masuk
                </button>
            </form>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-bmkg-blue transition-colors">
                ← Kembali ke situs
            </a>
        </div>
    </div>

</body>
</html>
