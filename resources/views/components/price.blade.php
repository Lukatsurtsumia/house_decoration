@props(['amount', 'unit' => null, 'currency' => '₾', 'prefix' => '', 'from' => null, 'unitClass' => ''])

<span {{ $attributes }}>{{ $prefix }}{{ $amount }} {{ $currency }}{{ $from }}@if ($unit) <span class="{{ $unitClass }}">/ {{ $unit }}</span>@endif</span>
