<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $email->subject }}
            </h2>
            <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 pb-4 border-b border-gray-200">
                        <p class="text-sm text-gray-500">
                            <strong>De:</strong> {{ $email->sender }}
                        </p>
                        <p class="text-sm text-gray-500">
                            <strong>Para:</strong> {{ $email->recipient }}
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            <strong>Data:</strong> {{ $email->created_at->format('d/m/Y \à\s H:i') }}
                        </p>
                    </div>
                    
                    <div class="whitespace-pre-wrap">
                        {{ $email->body }}
                    </div>
                    
                    <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                        <a href="{{ route('emails.compose', ['recipient' => $email->sender]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Responder
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
