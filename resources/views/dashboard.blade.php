<x-app-layout>
    <!-- Wrapper principal com estado Alpine para o menu mobile -->
    <div x-data="{ sidebarOpen: false }" class="flex h-full w-full relative bg-gray-50 overflow-hidden">
        
        <!-- Fundo escuro quando a sidebar estiver aberta no Mobile -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 md:hidden" 
             @click="sidebarOpen = false" style="display: none;">
        </div>

        <!-- Coluna 1: Barra Lateral (Sidebar) -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-50 w-72 bg-[#0A1128] text-white transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:w-72 flex flex-col shadow-2xl md:shadow-none">
            
            <!-- Logo NC5 MAIL -->
            <div class="px-6 py-6 flex items-center justify-between md:justify-start">
                <div class="flex items-center">
                    <svg viewBox="0 0 640 200" xmlns="http://www.w3.org/2000/svg" class="h-12 w-auto">
                        <defs><style>.nc5{font-family:Arial,Helvetica,sans-serif;font-weight:700;font-size:74px;fill:#F4F5F7;letter-spacing:-2px}.mail{font-family:Arial,Helvetica,sans-serif;font-weight:700;font-size:42px;fill:#F4F5F7;letter-spacing:4px}</style></defs>
                        <g transform="translate(10,10) scale(0.85)">
                            <path d="M 150.79 64.44 A 62 62 0 1 1 116.05 40.11" fill="none" stroke="#F4F5F7" stroke-width="7" stroke-linecap="round"/>
                            <line x1="135.56" y1="49.21" x2="150.47" y2="27.91" stroke="#F4F5F7" stroke-width="4" stroke-linecap="round"/>
                            <!-- Ponto de sinal em magenta como descrito no manual opcional -->
                            <circle cx="150.47" cy="27.91" r="9" fill="#E63888"/>
                        </g>
                        <text x="196" y="116" class="nc5">NC5</text>
                        <text x="198" y="160" class="mail">MAIL</text>
                    </svg>
                </div>
                <!-- Botão fechar (Mobile) -->
                <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Botão Escrever -->
            <div class="px-6 py-4">
                <a href="{{ route('dashboard', ['compose' => true]) }}" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-[#0A1128] bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-offset-[#0A1128] transition-all transform hover:scale-[1.02]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nova Mensagem
                </a>
            </div>

            <!-- Navegação -->
            <nav class="flex-1 px-4 space-y-2 mt-4 overflow-y-auto">
                <p class="px-2 text-xs font-semibold text-[#8A8F9C] uppercase tracking-wider mb-2">Pastas</p>
                <a href="{{ route('dashboard', ['folder' => 'inbox']) }}" class="{{ $folder == 'inbox' ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                    <svg class="{{ $folder == 'inbox' ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }} mr-3 flex-shrink-0 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    Caixa de Entrada
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-white text-[#0A1128] py-0.5 px-2.5 rounded-full text-xs font-bold">{{ $unreadCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('dashboard', ['folder' => 'sent']) }}" class="{{ $folder == 'sent' ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                    <svg class="{{ $folder == 'sent' ? 'text-white' : 'text-gray-500 group-hover:text-gray-300' }} mr-3 flex-shrink-0 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Enviados
                </a>
            </nav>

            <!-- Perfil / Logout -->
            <div class="px-4 py-4 border-t border-white/10">
                <div class="flex items-center justify-between p-2 rounded-lg bg-white/5">
                    <div class="flex items-center truncate">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm shadow-inner">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3 truncate">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider truncate">{{ auth()->user()->company ? auth()->user()->company->name : 'SaaS Admin' }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="p-1.5 text-gray-400 hover:text-white hover:bg-white/10 rounded-md transition-colors" title="Sair">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer NC5 -->
            <div class="px-4 py-4 bg-[#050914] text-center">
                <p class="text-[10px] text-[#8A8F9C] uppercase tracking-widest leading-relaxed">
                    Tecnologia <span class="text-white font-bold">NC5 Hub Digital</span><br>
                    Feito com carinho para sua empresa!
                </p>
            </div>
        </div>

        <!-- Coluna 2: Lista de E-mails (Fica oculta no mobile se um email estiver selecionado ou compondo) -->
        <div class="{{ (isset($selectedEmail) || $compose) ? 'hidden md:flex' : 'flex' }} w-full md:w-[400px] bg-white border-r border-gray-200 flex-col h-full shadow-sm z-10">
            <!-- Topo da Lista Mobile / Desktop -->
            <div class="p-4 border-b border-gray-100 flex items-center justify-between h-[72px] bg-white shadow-sm shrink-0">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="md:hidden mr-3 text-gray-500 hover:text-slate-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h3 class="text-xl font-bold text-gray-800 capitalize">{{ $folder == 'sent' ? 'Enviados' : 'Caixa de Entrada' }}</h3>
                </div>
                <span class="text-xs font-medium bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full">{{ $emails->count() }}</span>
            </div>

            <!-- Lista Rolável -->
            <div class="flex-1 overflow-y-auto bg-gray-50 md:bg-white custom-scrollbar">
                @if($emails->isEmpty())
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 p-6 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-gray-500 font-medium text-sm">Caixa vazia!</p>
                        <p class="text-xs mt-1">Você não possui mensagens aqui no momento.</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($emails as $email)
                            @php
                                $isSelected = isset($selectedEmail) && $selectedEmail->id == $email->id;
                            @endphp
                            <li class="relative transition-colors duration-150 {{ $isSelected ? 'bg-slate-50 border-l-4 border-slate-500' : 'bg-white hover:bg-gray-50 border-l-4 border-transparent' }}">
                                <a href="{{ route('dashboard', ['folder' => $folder, 'id' => $email->id]) }}" class="block p-4">
                                    <div class="flex justify-between items-baseline mb-1">
                                        <p class="text-sm font-semibold {{ !$email->is_read && $folder == 'inbox' ? 'text-gray-900' : 'text-gray-700' }} truncate pr-2">
                                            {{ $folder == 'inbox' ? $email->sender : $email->recipient }}
                                        </p>
                                        <p class="text-[11px] font-medium {{ !$email->is_read && $folder == 'inbox' ? 'text-slate-600' : 'text-gray-400' }} whitespace-nowrap">
                                            {{ $email->created_at->format('d/m H:i') }}
                                        </p>
                                    </div>
                                    <p class="text-sm {{ !$email->is_read && $folder == 'inbox' ? 'font-bold text-gray-900' : 'font-medium text-gray-600' }} truncate mb-1">
                                        {{ $email->subject }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate leading-relaxed">
                                        {{ Str::limit($email->body, 60) }}
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Coluna 3: Painel Principal (Leitura / Composição) (Oculto no mobile se não houver email selecionado) -->
        <div class="{{ (!isset($selectedEmail) && !$compose) ? 'hidden md:flex' : 'flex' }} flex-1 bg-white flex-col h-full overflow-hidden relative shadow-inner md:shadow-none">
            
            @if (session('status'))
                <div class="absolute top-4 right-4 z-50 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex items-center justify-between" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <p class="text-sm font-medium">{{ session('status') }}</p>
                    <button @click="show = false" class="ml-4 text-green-500 hover:text-green-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            @if($compose)
                <!-- Header Mobile Volta -->
                <div class="md:hidden flex items-center p-4 border-b border-gray-100 shrink-0">
                    <a href="{{ route('dashboard') }}" class="mr-3 text-gray-500 hover:text-gray-800 p-1 bg-gray-100 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <h2 class="text-lg font-bold text-gray-800">Nova Mensagem</h2>
                </div>

                <!-- Tela de Escrever Mensagem -->
                <div class="flex-1 overflow-y-auto">
                    <div class="max-w-4xl mx-auto py-6 px-6 md:py-10 md:px-12">
                        <h2 class="hidden md:block text-3xl font-bold text-gray-900 mb-8 tracking-tight">Escrever Mensagem</h2>
                        <form action="{{ route('emails.send') }}" method="POST" class="bg-white md:p-8 md:rounded-2xl md:shadow-sm md:border md:border-gray-100 space-y-6">
                            @csrf
                            
                            <div>
                                <label for="recipient" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Para</label>
                                <input type="email" name="recipient" id="recipient" placeholder="email@destinatario.com" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 transition-all sm:text-sm" required>
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Assunto</label>
                                <input type="text" name="subject" id="subject" placeholder="Do que se trata?" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 transition-all sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="body" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mensagem</label>
                                <textarea name="body" id="body" rows="12" placeholder="Escreva sua mensagem aqui..." class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 transition-all sm:text-sm resize-none" required></textarea>
                            </div>
                            
                            <div class="flex justify-end pt-4 border-t border-gray-100 space-x-3">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center bg-white border border-gray-300 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-50 transition font-semibold text-sm shadow-sm">Cancelar</a>
                                <button type="submit" class="inline-flex items-center justify-center bg-gradient-to-r from-slate-500 to-slate-600 text-white px-8 py-2.5 rounded-xl hover:from-slate-600 hover:to-slate-700 transition font-bold text-sm shadow-md">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Enviar Agora
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif(isset($selectedEmail))
                <!-- Header Mobile Volta -->
                <div class="md:hidden flex items-center p-4 border-b border-gray-100 shrink-0 bg-white">
                    <a href="{{ route('dashboard', ['folder' => $folder]) }}" class="mr-3 text-gray-500 hover:text-gray-800 p-1 bg-gray-100 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-widest truncate">Visualizando</span>
                </div>

                <!-- Tela de Leitura de E-mail -->
                <div class="flex-1 overflow-y-auto bg-white custom-scrollbar">
                    <div class="max-w-5xl mx-auto py-8 px-6 md:px-12">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 pb-6 border-b border-gray-100">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight mb-4 md:mb-0 pr-4">{{ $selectedEmail->subject }}</h2>
                            <span class="inline-flex items-center text-xs font-semibold text-slate-700 bg-slate-100 px-3 py-1.5 rounded-full shrink-0 self-start md:self-auto">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                {{ $folder == 'sent' ? 'Enviado' : 'Caixa de Entrada' }}
                            </span>
                        </div>
                        
                        <div class="flex items-start md:items-center mb-8 bg-gray-50 p-4 md:p-6 rounded-2xl border border-gray-100">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-gray-700 font-bold text-xl mr-4 shrink-0 shadow-sm border border-white">
                                {{ substr($folder == 'inbox' ? $selectedEmail->sender : $selectedEmail->recipient, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-bold text-gray-900 truncate">
                                    {{ $folder == 'inbox' ? $selectedEmail->sender : 'Para: ' . $selectedEmail->recipient }}
                                </p>
                                <p class="text-sm text-gray-500 mt-0.5 font-medium">{{ $selectedEmail->created_at->format('d \d\e F \d\e Y, \à\s H:i') }}</p>
                            </div>
                        </div>

                        <div class="prose max-w-none text-gray-800 whitespace-pre-wrap leading-relaxed text-base">
                            {{ $selectedEmail->body }}
                        </div>
                        
                        <div class="mt-12 pt-8 border-t border-gray-100 flex space-x-4">
                            <a href="{{ route('dashboard', ['compose' => true]) }}" class="inline-flex items-center px-6 py-2.5 border-2 border-gray-200 shadow-sm text-sm font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                Responder
                            </a>
                            <a href="{{ route('dashboard', ['compose' => true]) }}" class="inline-flex items-center px-6 py-2.5 border-2 border-gray-200 shadow-sm text-sm font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" transform="scale(-1, 1) translate(-24, 0)"></path></svg>
                                Encaminhar
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Placeholder Vazio (Aparece no Desktop quando nada está selecionado) -->
                <div class="hidden md:flex h-full flex-col items-center justify-center text-gray-400 bg-gray-50/50">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6 shadow-sm border border-gray-200">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-xl font-bold text-gray-700 mb-2">Vivensi.Mail</p>
                    <p class="text-sm font-medium text-gray-500 max-w-sm text-center">Selecione uma mensagem na lista à esquerda para ler o seu conteúdo completo.</p>
                </div>
            @endif
        </div>
    </div>
    
    <style>
        /* Estilização da barra de rolagem (opcional) */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background-color: #94a3b8;
        }
    </style>
</x-app-layout>
