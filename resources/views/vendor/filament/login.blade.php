<div class="flex flex-col items-center justify-center -mt-8 mb-6">
    <!-- NC5 Logo -->
    <div class="text-4xl font-extrabold tracking-tight text-[#0A1128] mb-2">
        NC5<span class="text-[#FF7A1A]">.</span>
    </div>
    <h2 class="text-lg text-gray-500 font-medium">Acesso Restrito</h2>
</div>

<form wire:submit.prevent="authenticate" class="space-y-8">
    {{ $this->form }}

    <x-filament::button type="submit" form="authenticate" class="w-full" style="background-color: #FF7A1A; color: white;">
        Acessar Painel
    </x-filament::button>
</form>
