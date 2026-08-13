<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="O NC5 Mail é a infraestrutura de e-mail definitiva para empresas que escalam, contando com o agente BruceIA para análises inteligentes de sentimento e sugestões automáticas.">

        <title>NC5 Mail — E-mail aplicado a negócios que escalam</title>
        
        <!-- Favicon SVG -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'><rect width='200' height='200' fill='%230A0A0B' rx='46'/><rect x='58' y='46' width='26' height='108' fill='%23FF7A1A' rx='13'/><rect x='58' y='44' width='76' height='58' fill='%23FF7A1A' rx='29'/><rect x='80' y='56' width='42' height='34' fill='%230A0A0B' rx='17'/><rect x='58' y='98' width='84' height='62' fill='%23FF7A1A' rx='31'/><rect x='80' y='110' width='48' height='38' fill='%230A0A0B' rx='19'/><circle cx='132' cy='100' r='9' fill='%230A0A0B'/><line x1='140' y1='94' x2='158' y2='76' stroke='%23FF7A1A' stroke-width='5' stroke-linecap='round'/><circle cx='162' cy='72' r='6' fill='%23FF7A1A'/></svg>">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body { font-family: 'Figtree', sans-serif; }
            .bg-tinta { background-color: #0A1128; }
            .text-magenta { color: #E63888; }
            .bg-magenta { background-color: #E63888; }
        </style>
    </head>
    <body class="antialiased bg-white text-gray-900 selection:bg-blue-100 selection:text-blue-900">
        
        <!-- Navbar -->
        <nav class="border-b border-gray-100 py-6">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div class="flex items-center">
                    <svg viewBox="0 0 640 200" xmlns="http://www.w3.org/2000/svg" class="h-8 w-auto">
                        <defs><style>.nc5{font-family:Arial,Helvetica,sans-serif;font-weight:700;font-size:74px;fill:#0A1128;letter-spacing:-2px}.mail{font-family:Arial,Helvetica,sans-serif;font-weight:700;font-size:42px;fill:#0A1128;letter-spacing:4px}</style></defs>
                        <g transform="translate(10,10) scale(0.85)">
                            <path d="M 150.79 64.44 A 62 62 0 1 1 116.05 40.11" fill="none" stroke="#0A1128" stroke-width="7" stroke-linecap="round"/>
                            <line x1="135.56" y1="49.21" x2="150.47" y2="27.91" stroke="#0A1128" stroke-width="4" stroke-linecap="round"/>
                            <circle cx="150.47" cy="27.91" r="9" fill="#1a73e8"/>
                        </g>
                        <text x="196" y="116" class="nc5">NC5</text>
                        <text x="198" y="160" class="mail">MAIL</text>
                    </svg>
                </div>
                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-[#1a73e8] font-medium transition-colors">Acessar Painel</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white bg-[#1a73e8] hover:bg-blue-700 px-6 py-2.5 rounded font-medium transition-colors">Fazer Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero: Minimalist -->
        <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 flex flex-col items-center text-center">
            
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-[#0A1128] mb-6">
                E-mail aplicado a <br> negócios que escalam.
            </h1>
            
            <p class="mt-4 text-xl sm:text-2xl text-gray-500 max-w-3xl leading-relaxed mb-10">
                Uma infraestrutura limpa, rápida e inteligente. O <strong>NC5 Mail</strong> une a simplicidade que você precisa com a robustez corporativa que o seu negócio exige.
            </p>
            
            <a href="{{ route('login') }}" class="inline-flex items-center text-lg font-medium text-[#1a73e8] hover:text-blue-800 transition-colors group">
                Acessar meu webmail
                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>

        </main>

        <!-- Divider -->
        <div class="max-w-3xl mx-auto border-t border-gray-100"></div>

        <!-- Bruce IA Section -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="flex flex-col items-start">
                    
                    <!-- Destaque Limpo para a Logo do BruceIA -->
                    <div class="mb-10">
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="h-28 w-28">
                            <defs><style>.accent-bruce{fill:#FF7A1A}.hole-bruce{fill:#0A0A0B}</style></defs>
                            <rect class="accent-bruce" x="58" y="46" width="26" height="108" rx="13"/>
                            <rect class="accent-bruce" x="58" y="44" width="76" height="58" rx="29"/>
                            <rect class="hole-bruce" x="80" y="56" width="42" height="34" rx="17"/>
                            <rect class="accent-bruce" x="58" y="98" width="84" height="62" rx="31"/>
                            <rect class="hole-bruce" x="80" y="110" width="48" height="38" rx="19"/>
                            <circle class="hole-bruce" cx="132" cy="100" r="9"/>
                            <line x1="140" y1="94" x2="158" y2="76" stroke="#FF7A1A" stroke-width="5" stroke-linecap="round"/>
                            <circle class="accent-bruce" cx="162" cy="72" r="6"/>
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#0A0A0B] mb-4 tracking-tight">
                        Bruce<span class="text-[#FF7A1A]">IA</span>
                    </h2>
                    <h3 class="text-2xl text-gray-800 font-medium mb-6">Seu assistente autônomo.</h3>
                    
                    <p class="text-lg text-gray-500 leading-relaxed">
                        Nós não adicionamos IA apenas como um enfeite. O <strong>BruceIA</strong> lê os e-mails recebidos, analisa o sentimento do seu cliente, classifica a urgência de atendimento e prepara automaticamente sugestões de resposta para a sua equipe. Produtividade silenciosa e invisível.
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-10 border border-gray-100">
                    <div class="space-y-8">
                        <div>
                            <div class="text-sm font-semibold text-[#FF7A1A] uppercase tracking-wider mb-2">Análise de Sentimento</div>
                            <p class="text-gray-700">Compreensão instantânea do tom do cliente (positivo, frustrado, neutro) antes mesmo de você abrir a mensagem.</p>
                        </div>
                        <div class="border-t border-gray-200 pt-6">
                            <div class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-2">Resumo Inteligente</div>
                            <p class="text-gray-700">Textos longos reduzidos a até 2 linhas cruciais. Vá direto ao ponto que interessa para o negócio.</p>
                        </div>
                        <div class="border-t border-gray-200 pt-6">
                            <div class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-2">Respostas Sugeridas</div>
                            <p class="text-gray-700">O BruceIA redige esboços profissionais e empáticos baseados no contexto da thread, prontos para aprovação.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer (Exact Reference Match) -->
        <footer class="pt-32 pb-8 bg-white border-t border-gray-50 mt-12 overflow-hidden font-sans">
            <div class="max-w-[1400px] mx-auto px-6 lg:px-12 flex flex-col">
                
                <!-- Top Links Section (As in image) -->
                <div class="flex justify-center md:justify-end md:pr-[15%] mb-20">
                    <div class="grid grid-cols-2 gap-x-24 gap-y-3 text-[15px] font-medium text-gray-700">
                        <div class="flex flex-col space-y-3">
                            <a href="#" class="hover:text-black transition-colors">Download</a>
                            <a href="#" class="hover:text-black transition-colors">Product</a>
                            <a href="#" class="hover:text-black transition-colors">Docs</a>
                            <a href="#" class="hover:text-black transition-colors">Changelog</a>
                            <a href="#" class="hover:text-black transition-colors">Press</a>
                            <a href="#" class="hover:text-black transition-colors">Releases</a>
                        </div>
                        <div class="flex flex-col space-y-3">
                            <a href="#" class="hover:text-black transition-colors">Blog</a>
                            <a href="#" class="hover:text-black transition-colors">Pricing</a>
                            <a href="#" class="hover:text-black transition-colors">Use Cases</a>
                        </div>
                    </div>
                </div>

                <!-- Giant Brand Text -->
                <div class="w-full flex justify-center mb-4">
                    <h2 class="text-[15vw] xl:text-[250px] font-medium text-[#111] leading-none tracking-tight" style="letter-spacing: -0.04em; margin-bottom: -0.05em;">
                        NC5 Mail
                    </h2>
                </div>
                
                <!-- Divider -->
                <div class="w-full border-t border-gray-200 mt-2 mb-6"></div>
                
                <!-- Bottom Bar -->
                <div class="w-full flex flex-col md:flex-row justify-between items-center text-[14px] font-medium text-gray-500 gap-6 md:gap-0">
                    <div class="flex items-center">
                        <span class="font-medium text-gray-800 text-lg tracking-tight">NC5 Hub Digital</span>
                    </div>
                    
                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="#" class="hover:text-gray-900 transition-colors">Sobre a NC5</a>
                        <a href="#" class="hover:text-gray-900 transition-colors">Produtos</a>
                        <a href="{{ route('legal.privacy') }}" class="hover:text-gray-900 transition-colors">Privacidade</a>
                        <a href="{{ route('legal.terms') }}" class="hover:text-gray-900 transition-colors">Termos</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Cookie Consent Banner -->
        <div id="cookie-banner" class="fixed bottom-0 left-0 right-0 bg-[#0A1128] text-white p-4 shadow-2xl transform translate-y-full transition-transform duration-500 z-50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm">
                Utilizamos cookies para oferecer a melhor experiência em nossa plataforma. Ao continuar navegando, você concorda com a nossa <a href="{{ route('legal.privacy') }}" class="text-[#1a73e8] underline">Política de Privacidade</a> e nossos <a href="{{ route('legal.terms') }}" class="text-[#1a73e8] underline">Termos de Uso</a>.
            </div>
            <button onclick="acceptCookies()" class="shrink-0 bg-[#1a73e8] hover:bg-blue-600 text-white px-6 py-2 rounded-md font-medium transition-colors">
                Entendi e Aceito
            </button>
        </div>

        <script>
            function acceptCookies() {
                localStorage.setItem('nc5_cookie_consent', 'accepted');
                document.getElementById('cookie-banner').classList.add('translate-y-full');
            }

            document.addEventListener('DOMContentLoaded', () => {
                if (!localStorage.getItem('nc5_cookie_consent')) {
                    setTimeout(() => {
                        document.getElementById('cookie-banner').classList.remove('translate-y-full');
                    }, 500);
                }
            });
        </script>

    </body>
</html>
