<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-primary border border-transparent rounded-full font-bold text-on-primary tracking-wide transition ease-in-out duration-150 active:scale-95 hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
