<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">PINGU</div>

    <div class="nav-items">
        @foreach(config('navigation.sidebar', []) as $item)
        @if(isset($item['disabled']) && $item['disabled'])
        {{-- Menu yang disabled (belum aktif) --}}
        <button class="nav-item" disabled title="{{ $item['name'] }} (Coming Soon)">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $item['icon'] !!}
            </svg>
            <span>{{ $item['name'] }}</span>
        </button>
        @else
        {{-- Menu aktif dengan route --}}
        <a
            href="{{ route($item['route']) }}"
            class="nav-item {{ Request::is($item['active'] ?? $item['route']) ? 'active' : '' }}"
            title="{{ $item['name'] }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $item['icon'] !!}
            </svg>
            <span>{{ $item['name'] }}</span>
        </a>
        @endif
        @endforeach
    </div>

    {{-- Logout Button --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn" title="Logout">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                <path d="M7.5 1v7h1V1z" />
                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
            </svg>
        </button>
    </form>
</div>