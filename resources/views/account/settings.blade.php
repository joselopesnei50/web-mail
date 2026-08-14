<x-app-layout>
    <div class="min-h-full w-full bg-gray-50 overflow-y-auto">
        <div class="max-w-3xl mx-auto py-10 px-6">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Configurações da Conta</h1>
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">← Voltar ao webmail</a>
            </div>

            @if (session('status'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded">
                    <p class="text-sm font-medium">{{ session('status') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded">
                    <ul class="text-sm space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">Perfil</h2>
                <p class="text-sm text-gray-500 mb-6">Dados que aparecem quando você envia um e-mail.</p>

                <form method="POST" action="{{ route('account.settings.update') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Nome</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Nome de exibição (opcional)</label>
                        <input type="text" name="display_name" value="{{ old('display_name', $user->display_name) }}"
                               placeholder="Se vazio, usa o nome acima"
                               class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 sm:text-sm">
                        <p class="text-xs text-gray-400 mt-1">Aparece no "De:" das mensagens enviadas.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">E-mail</label>
                        <input type="email" value="{{ $user->email }}" disabled
                               class="block w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-gray-500 sm:text-sm cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1">Este endereço é sua conta de login e caixa postal — só um super admin pode alterar.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Assinatura</label>
                        <textarea name="signature" rows="6" placeholder="Ex: Atenciosamente, Fulano — NC5 Hub Digital — +55 11 99999-0000"
                                  class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 sm:text-sm resize-none">{{ old('signature', $user->signature) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Adicionada automaticamente ao final de cada mensagem enviada.</p>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center bg-gradient-to-r from-slate-500 to-slate-600 text-white px-6 py-2.5 rounded-xl hover:from-slate-600 hover:to-slate-700 font-semibold text-sm shadow-md">
                            Salvar Perfil
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">Alterar Senha</h2>
                <p class="text-sm text-gray-500 mb-6">A senha do painel e a senha da caixa de e-mail (IMAP/SMTP) serão atualizadas juntas.</p>

                <form method="POST" action="{{ route('account.settings.password') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Senha atual</label>
                        <input type="password" name="current_password" required
                               class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Nova senha (mín. 8 caracteres)</label>
                        <input type="password" name="password" required minlength="8"
                               class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Confirmar nova senha</label>
                        <input type="password" name="password_confirmation" required minlength="8"
                               class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 focus:border-slate-500 focus:bg-white focus:ring-2 focus:ring-slate-200 sm:text-sm">
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center bg-white border-2 border-slate-300 text-slate-700 px-6 py-2.5 rounded-xl hover:bg-slate-50 font-semibold text-sm">
                            Atualizar Senha
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
