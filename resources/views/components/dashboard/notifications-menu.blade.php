<!-- Notifications Dropdown Menu -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if ($unread > 0)
        <span class="badge badge-warning navbar-badge">{{ $unread > 99? '99+' : $unread }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">{{ $unread }} Notifications</span>
        <div class="dropdown-divider"></div>
        @foreach ($notifications as $notification)
        <a href="{{ $notification->data['link'] }}?notification_id={{ $notification->id }}" class="dropdown-item">
            <i class="{{ $notification->data['icon'] }} mr-2"></i>
            @if ($notification->read())
            {{ $notification->data['title'] }}
            @else
            <strong>{{ $notification->data['title'] }}</strong>
            @endif
            <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
        </a>
        <div class="dropdown-divider"></div>
        @endforeach
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>