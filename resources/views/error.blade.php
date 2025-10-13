<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">

            <div class="w-full overflow-hidden bg-white shadow-md sm:max-w-lg sm:rounded-lg">
                <div class="flex items-center justify-center p-6">
                    <a href="/">
                        <img
                            src="https://www.stura-btu.de/curator/media/studierendenvertretung-logo.jpg?fm=webp&h=105&w=768&s=8391320acbaa52fd2ec176bdb08692e2"
                            alt="Logo der Studierendenvertretung der BTU Cottbus-Senftenberg"
                            class="w-auto h-10 text-gray-500 fill-current"
                        >
                    </a>
                </div>

                <main class="p-6 border-t border-gray-200">
                    <h1 class="text-xl font-semibold">
                        {{ __('oidc::error.title') }}
                    </h1>
                
                    <p class="mt-6">
                        [DE] {{ __('oidc::error.description_de') }}
                    </p>
                
                    <p class="mt-2">
                        [EN] {{ __('oidc::error.description_en') }}
                    </p>
                
                    <p class="mt-6">
                        <a
                            href="{{ route('auth.oidc.redirect') }}"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            {{ __('oidc::error.login') }} &rightarrow;
                        </a>
                    </p>
                </main>
            </div>
        </div>
    </body>
</html>
