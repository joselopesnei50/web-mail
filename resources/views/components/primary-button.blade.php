<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-[#0A1128] border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-[#0A1128]/90 focus:bg-[#0A1128]/90 active:bg-black focus:outline-none focus:ring-2 focus:ring-[#0A1128] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
