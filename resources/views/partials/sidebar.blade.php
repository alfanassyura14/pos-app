<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">PINGU</div>

    <div class="nav-items">
        @foreach(config('navigation.sidebar', []) as $item)
        @php
            $userMenuAccess = auth()->user()->menu_access ?? [];
            $accessKey = $item['access_key'] ?? strtolower($item['name']);
            $hasAccess = auth()->user()->role === 'admin' || in_array($accessKey, $userMenuAccess);
        @endphp
        
        @if(isset($item['disabled']) && $item['disabled'])
        {{-- Menu yang disabled (belum aktif) --}}
        <button class="nav-item" disabled title="{{ $item['name'] }} (Coming Soon)">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $item['icon'] !!}
            </svg>
            <span>{{ $item['name'] }}</span>
        </button>
        @elseif(!$hasAccess)
        {{-- Menu yang tidak ada akses --}}
        <button 
            class="nav-item nav-item-locked" 
            onclick="showAccessDeniedModal('{{ $item['name'] }}')" 
            title="{{ $item['name'] }} (No Access)">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $item['icon'] !!}
            </svg>
            <span>{{ $item['name'] }}</span>
            <svg class="lock-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="12" height="12">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
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