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
                        {{ __('oidc::login.title') }}
                    </h1>
                
                    <p class="mt-6">
                        {{ __('oidc::login.description') }}
                    </p>
                
                    <p class="mt-6">
                        <a
                            href="{{ route('auth.oidc.redirect') }}"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            {{ __('oidc::login.action') }} &rightarrow;
                        </a>
                    </p>

                    @if(Request::query('error') === 'no_access')
                    <div class="mt-6 rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 text-red-400">
                                    <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" fill-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">{{ __('oidc::login.no_access') }}</h3>
                            </div>
                        </div>
                    </div>
                    @endif

                </main>
            </div>
        </div>
    </body>
</html>
