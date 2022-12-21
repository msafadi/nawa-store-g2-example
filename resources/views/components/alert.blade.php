<div class="alert alert-{{ $type }}">
    @if ((string) $slot)
        {{ $slot }}
    @else
        Default Message
    @endif
</div>