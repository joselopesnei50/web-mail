<x-filament::page>
    <form wire:submit.prevent="save" class="space-y-6 max-w-4xl">
        {{ $this->form }}

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 dark:bg-gray-800 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Integração DeepSeek (BruceIA)</h3>
            
            <div class="space-y-4">
                <div>
                    <label for="deepseekKey" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Chave da API</label>
                    <input 
                        type="password" 
                        id="deepseekKey" 
                        wire:model.defer="deepseekKey" 
                        placeholder="sk-..." 
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#FF7A1A] focus:ring-[#FF7A1A] sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-2 border"
                    >
                    <p class="mt-2 text-sm text-gray-500">
                        Insira a sua chave secreta da DeepSeek para ativar o processamento anti-spam inteligente (BruceIA).
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-start">
                <button 
                    type="submit" 
                    style="background-color: #FF7A1A;"
                    class="inline-flex justify-center rounded-lg border border-transparent px-6 py-2 text-sm font-medium text-white shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#FF7A1A] focus:ring-offset-2 transition-colors"
                >
                    Salvar Chave
                </button>
            </div>
        </div>
    </form>
</x-filament::page>
