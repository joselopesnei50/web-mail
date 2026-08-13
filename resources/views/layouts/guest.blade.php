<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>NC5 Mail | Acesso e Setup</title>
        <meta name="description" content="Central de e-mails inteligentes com IA - NC5 Hub Digital">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: { sans: ['Inter', 'sans-serif'] },
                        colors: { brand: { dark: '#0A1128', accent: '#FF7A1A' } }
                    }
                }
            }
        </script>
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="text-brand-dark antialiased bg-white selection:bg-brand-accent selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md px-8 py-10 bg-white sm:rounded-2xl sm:border sm:border-gray-100 sm:shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="flex justify-center mb-10">
                    <a href="/">
                        <!-- NC5 Logo -->
                        <div class="text-4xl font-extrabold tracking-tight text-brand-dark">
                            NC5<span class="text-brand-accent">.</span>
                        </div>
                    </a>
                </div>

                {{ $slot }}
            </div>
            
            <div class="mt-8 text-sm text-gray-400">
                &copy; {{ date('Y') }} NC5 Hub Digital. Todos os direitos reservados.
            </div>
        </div>
    </body>
</html>
