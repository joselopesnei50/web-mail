<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NC5 Mail') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles (CDN Fallback) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#0A1128]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/">
                    <svg viewBox="0 0 640 200" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto mx-auto drop-shadow-xl">
                        <defs><style>.nc5{font-family:Arial,Helvetica,sans-serif;font-weight:700;font-size:74px;fill:#F4F5F7;letter-spacing:-2px}.mail{font-family:Arial,Helvetica,sans-serif;font-weight:700;font-size:42px;fill:#F4F5F7;letter-spacing:4px}</style></defs>
                        <g transform="translate(10,10) scale(0.85)">
                            <path d="M 150.79 64.44 A 62 62 0 1 1 116.05 40.11" fill="none" stroke="#F4F5F7" stroke-width="7" stroke-linecap="round"/>
                            <line x1="135.56" y1="49.21" x2="150.47" y2="27.91" stroke="#F4F5F7" stroke-width="4" stroke-linecap="round"/>
                            <circle cx="150.47" cy="27.91" r="9" fill="#E63888"/>
                        </g>
                        <text x="196" y="116" class="nc5">NC5</text>
                        <text x="198" y="160" class="mail">MAIL</text>
                    </svg>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-100">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-[11px] text-[#8A8F9C] uppercase tracking-widest leading-relaxed">
                    Tecnologia <span class="text-[#E63888] font-bold">NC5 Hub Digital</span><br>
                    Feito com carinho para sua empresa!
                </p>
            </div>
        </div>
    </body>
</html>
