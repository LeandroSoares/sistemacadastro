<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Casa Caridade</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="min-h-screen bg-white dark:bg-black flex flex-col justify-between">
            <!-- Navigation -->
            <header class="w-full px-4 py-2">
                @if (Route::has('login'))
                    <nav class="flex justify-end">
                        @auth
                            <a href="{{ url('/home') }}" class="rounded-md px-2 py-1 text-sm text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80">
                                Home
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-md px-2 py-1 text-sm text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80">
                                Login
                            </a>

                            <!-- @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ms-2 rounded-md px-2 py-1 text-sm text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80">
                                    Register
                                </a>
                            @endif -->
                        @endauth
                    </nav>
                @endif
            </header>

            <!-- Main Content -->
            <main class="flex-1 flex items-center justify-center px-4 py-6">
                <div class="w-full text-center">
                    <img 
                        src="{{ asset('images/logo.jpg') }}" 
                        alt="Casa Caridade" 
                        class="mx-auto w-64 h-auto rounded-lg"
                    />
                </div>
            </main>

            <!-- Footer -->
            <footer class="w-full bg-white dark:bg-gray-900 py-4">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Casa de Caridade Legião de Oxóssi e Ogum
                    </h2>
                    <address class="text-sm text-gray-600 dark:text-gray-400 not-italic">
                        Rua Ilhéus do Prata, 26 - Imirim<br>
                        CEP: 02478-060<br>
                        São Paulo - SP<br>
                        <p class="mt-1">
                            Cel: (11) 99320-3215
                        </p>
                    </address>
                </div>
            </footer>
        </div>
    </body>
</html>
