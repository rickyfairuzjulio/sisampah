<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3.5 bg-primary border border-transparent rounded-full font-bold text-on-primary tracking-wide hover:bg-primary-container focus:bg-primary-container active:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 active:scale-[0.98] shadow-sm']) }}>
    {{ $slot }}
</button>
