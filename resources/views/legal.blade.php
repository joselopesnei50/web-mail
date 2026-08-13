<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - NC5 Mail</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'><rect width='200' height='200' fill='%230A0A0B' rx='46'/><rect x='58' y='46' width='26' height='108' fill='%23FF7A1A' rx='13'/><rect x='58' y='44' width='76' height='58' fill='%23FF7A1A' rx='29'/><rect x='80' y='56' width='42' height='34' fill='%230A0A0B' rx='17'/><rect x='58' y='98' width='84' height='62' fill='%23FF7A1A' rx='31'/><rect x='80' y='110' width='48' height='38' fill='%230A0A0B' rx='19'/><circle cx='132' cy='100' r='9' fill='%230A0A0B'/><line x1='140' y1='94' x2='158' y2='76' stroke='%23FF7A1A' stroke-width='5' stroke-linecap='round'/><circle cx='162' cy='72' r='6' fill='%23FF7A1A'/></svg>">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Figtree', sans-serif; }</style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ url('/') }}" class="text-[#1a73e8] hover:underline mb-8 inline-block">&larr; Voltar para a página inicial</a>
        
        <h1 class="text-4xl font-bold mb-8">{{ $title }}</h1>
        
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 prose max-w-none">
            @if($content)
                {!! $content !!}
            @else
                <p class="text-gray-500 italic">O conteúdo para esta página ainda não foi configurado pelo administrador.</p>
            @endif
        </div>
        
        <footer class="mt-12 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} NC5 Hub Digital. Todos os direitos reservados.
        </footer>
    </div>
</body>
</html>
