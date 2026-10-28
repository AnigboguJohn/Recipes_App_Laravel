{{-- Line icons. Usage: @include('partials.icon', ['name' => 'clock']) --}}
@php
    $paths = [
        'home' => '<path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6h-6v6H4a1 1 0 0 1-1-1z"/>',
        'heart' => '<path d="M12 20.5s-7.5-4.6-9.3-9.4C1.4 7.6 3.6 4 7.2 4c2 0 3.6 1.1 4.8 2.8C13.2 5.1 14.8 4 16.8 4c3.6 0 5.8 3.6 4.5 7.1C19.5 15.9 12 20.5 12 20.5z"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'people' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c1-3.5 3.5-5.5 6.5-5.5s5.5 2 6.5 5.5"/><path d="M16 4.6a3.5 3.5 0 0 1 0 6.8M18 14.8c2 .7 3.2 2.5 3.8 5.2"/>',
        'chart' => '<path d="M5 20V14M12 20V9M19 20V4"/>',
        'flame' => '<path d="M12 21c-4 0-7-2.8-7-6.6 0-3.5 2.7-5.6 4-8.9.5 2 1.6 3.2 3 3.6-.3-2.7.8-5.1 3-6.1-.4 3 1.5 4.8 2.7 6.9.8 1.4 1.3 2.8 1.3 4.5 0 3.8-3 6.6-7 6.6z"/>',
        'back' => '<path d="M15 5l-7 7 7 7"/>',
        'next' => '<path d="m9 5 7 7-7 7"/>',
        'chef' => '<path d="M7 13.5V20h10v-6.5M7 13.5A4 4 0 0 1 6.5 6 5 5 0 0 1 12 3a5 5 0 0 1 5.5 3 4 4 0 0 1-.5 7.5M7 17h10"/>',
        'camera' => '<path d="M4 8h3l2-3h6l2 3h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13.5" r="3.5"/>',
        'edit' => '<path d="M4 20h4L19 9l-4-4L4 16z"/><path d="m13.5 6.5 4 4"/>',
        'trash' => '<path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/>',
        'logout' => '<path d="M15 4h4a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-4M10 8l-4 4 4 4M6 12h10"/>',
        'play' => '<path d="M7 4.5v15l12-7.5z"/>',
        'pause' => '<path d="M8 5v14M16 5v14"/>',
        'reset' => '<path d="M4 4v6h6"/><path d="M5.5 15a7 7 0 1 0 1.7-7.3L4 10"/>',
        'check' => '<path d="m5 12.5 4.5 4.5L19 7.5"/>',
        'bookmark' => '<path d="M6 3h12v18l-6-4-6 4z"/>',
        'list' => '<path d="M9 6h11M9 12h11M9 18h11M4 6h.01M4 12h.01M4 18h.01"/>',
    ];
@endphp
<svg class="ic {{ $class ?? '' }}" viewBox="0 0 24 24" aria-hidden="true">{!! $paths[$name] ?? '' !!}</svg>
