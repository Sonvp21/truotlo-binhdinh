<div class="relative mt-1">
    <input
        x-data
        x-ref="input"
        x-init="
            flatpickr($refs.input, {
                altInput: true,
                altFormat: 'd/m/Y',
                dateFormat: 'Y-m-d',
            })
        "
        type="text"
        {!! $attributes->merge(['class' => 'border-slate-300 focus:border-lime-500 focus:ring-lime-500 rounded-md shadow-sm w-full']) !!}
    />
    <div class="absolute right-0 top-0 px-3 py-2">
        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
    </div>
    @pushOnce('styles')
        <!-- Flatpickr -->
        <link href="{{ asset('vendor/flatpickr/flatpickr.css') }}" rel="stylesheet" />
    @endpushOnce

    @pushOnce('bottom_scripts')
        <script src="{{ asset('vendor/flatpickr/flatpickr.js') }}"></script>
    @endpushOnce
</div>
