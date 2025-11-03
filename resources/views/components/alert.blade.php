@props(['type' => 'success', 'message'])

@php
    $styles = [
        'success' => 'background: #10b981; color: #ffffff;',
        'error' => 'background: #ef4444; color: #ffffff;',
        'warning' => 'background: #f59e0b; color: #ffffff;',
        'info' => 'background: #3b82f6; color: #ffffff;',
    ];
    $style = $styles[$type] ?? $styles['info'];
@endphp

<div style="{{ $style }} padding: 1rem; border-radius: 6px; margin-bottom: 2rem;">
    {{ $message ?? $slot }}
</div>
