@props(['name', 'class' => 'size-5'])

<svg class="{{ $class }}" {{ $attributes->merge(['stroke-width' => '1.75']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('phone')
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z" />
            @break
        @case('mail')
            <rect x="3" y="5" width="18" height="14" rx="2" /><path d="m3.5 7 8.5 6 8.5-6" />
            @break
        @case('clock')
            <circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" />
            @break
        @case('pin')
            <path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21Z" /><circle cx="12" cy="9.5" r="2.5" />
            @break
        @case('arrow-right')
            <path d="M5 12h14M13 6l6 6-6 6" />
            @break
        @case('download')
            <path d="M12 4v11M7 10l5 5 5-5" /><path d="M5 20h14" />
            @break
        @case('plus')
            <path d="M12 5v14M5 12h14" />
            @break
        @case('minus')
            <path d="M5 12h14" />
            @break
        @case('menu')
            <path d="M4 8h16M4 16h16" />
            @break
        @case('close')
            <path d="M6 6l12 12M18 6 6 18" />
            @break
    @endswitch
</svg>
