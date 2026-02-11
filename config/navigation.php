<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sidebar Navigation Menu
    |--------------------------------------------------------------------------
    |
    | Konfigurasi menu navigasi untuk sidebar. Setiap menu memiliki:
    | - name: Nama menu yang ditampilkan
    | - icon: SVG path untuk icon
    | - route: Route name Laravel
    | - active: Pattern untuk menentukan menu aktif (opsional)
    |
    */

    'sidebar' => [
        [
            'name' => 'Dashboard',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
            'route' => 'dashboard',
            'active' => 'dashboard*'
        ],
        [
            'name' => 'Menu',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />',
            'route' => 'menu',
            'active' => 'menu*'
        ],
        [
            'name' => 'Inventory',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />',
            'route' => 'inventory',
            'active' => 'inventory*',
            'disabled' => true,
        ],
        [
            'name' => 'Reports',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
            'route' => 'reports',
            'active' => 'reports*',
            'disabled' => true
        ],
        [
            'name' => 'Orders',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />',
            'route' => 'orders.create',
            'active' => 'orders*',
        ],
        [
            'name' => 'Reservation',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />',
            'route' => 'reservations',
            'active' => 'reservations*',
            'disabled' => true
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Top Bar Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk top bar/navbar
    |
    */

    'topbar' => [
        'show_notifications' => true,
        'show_user_avatar' => true,
        'show_back_button' => false, // Default false, bisa di override per page
    ],
];
