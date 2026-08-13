<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configurações do Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <div class="flex items-center space-x-3 mb-2">
                                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10">
                                  <defs><style>.bg-bruce{fill:#0A0A0B}.accent-bruce{fill:#FF7A1A}.hole-bruce{fill:#0A0A0B}</style></defs>
                                  <rect class="bg-bruce" x="0" y="0" width="200" height="200" rx="46"/>
                                  <rect class="accent-bruce" x="58" y="46" width="26" height="108" rx="13"/>
                                  <rect class="accent-bruce" x="58" y="44" width="76" height="58" rx="29"/>
                                  <rect class="hole-bruce" x="80" y="56" width="42" height="34" rx="17"/>
                                  <rect class="accent-bruce" x="58" y="98" width="84" height="62" rx="31"/>
                                  <rect class="hole-bruce" x="80" y="110" width="48" height="38" rx="19"/>
                                  <circle class="hole-bruce" cx="132" cy="100" r="9"/>
                                  <line x1="140" y1="94" x2="158" y2="76" stroke="#FF7A1A" stroke-width="5" stroke-linecap="round"/>
                                  <circle class="accent-bruce" cx="162" cy="72" r="6"/>
                                </svg>
                                <h2 class="text-2xl font-bold text-[#0A0A0B]">
                                    Bruce<span class="text-[#FF7A1A]">IA</span>
                                </h2>
                            </div>
                            <p class="mt-1 text-sm text-[#3A3A3C]">
                                {{ __('Gerencie as chaves de API e credenciais do agente autônomo do sistema.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('settings.update') }}" class="mt-6 space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="deepseek_api_key" :value="__('DeepSeek API Key')" />
                                <x-text-input id="deepseek_api_key" name="deepseek_api_key" type="password" class="mt-1 block w-full" :value="$deepseekKey" placeholder="sk-..." />
                                <x-input-error class="mt-2" :messages="$errors->get('deepseek_api_key')" />
                                <p class="mt-2 text-xs text-gray-500">A chave será criptografada no banco de dados.</p>
                            </div>

                            <hr class="my-4 border-gray-200">

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Páginas Legais (HTML/Texto)</h3>
                                
                                <div class="mb-6">
                                    <x-input-label for="privacy_policy" :value="__('Política de Privacidade')" />
                                    <textarea id="privacy_policy" name="privacy_policy" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('privacy_policy', $privacyPolicy ?? '') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('privacy_policy')" />
                                </div>

                                <div>
                                    <x-input-label for="terms_of_use" :value="__('Termos de Uso')" />
                                    <textarea id="terms_of_use" name="terms_of_use" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('terms_of_use', $termsOfUse ?? '') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('terms_of_use')" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Salvar Configurações') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
