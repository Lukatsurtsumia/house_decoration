@props(['size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'size-7 rounded-md',
        'md' => 'size-9 rounded-lg',
    ][$size] ?? 'size-9 rounded-lg';
@endphp

{{-- A ceiling line with a single light under it. --}}
<span {{ $attributes->merge(['class' => "{$sizeClasses} inline-flex shrink-0 items-center justify-center bg-ink"]) }}>
    <svg viewBox="0 0 32 32" class="size-full" aria-hidden="true">
        <path d="M8 10.5h16" stroke="#fff" stroke-width="2.25" stroke-linecap="round" />
        <path d="M16 10.5v4" stroke="#fff" stroke-width="1.5" stroke-linecap="round" />
        <circle cx="16" cy="18" r="3.25" fill="var(--color-jade)" />
    </svg>
</span>
