# Dokumentasi Sistem Navigasi Dinamis

## Ringkasan
Sistem navigasi sidebar dan topbar sekarang sudah dinamis dan tidak perlu hardcode lagi. Semua konfigurasi menu berada di satu tempat yang mudah dikelola.

## Struktur File

```
config/
  └── navigation.php          # Konfigurasi menu navigasi

resources/views/
  ├── layouts/
  │   └── app.blade.php       # Layout utama aplikasi
  ├── partials/
  │   ├── sidebar.blade.php   # Component sidebar
  │   └── topbar.blade.php    # Component topbar
  ├── dashboard.blade.php     # Halaman dashboard (sudah menggunakan layout)
  └── menu.blade.php          # Halaman menu (sudah menggunakan layout)
```

## Cara Menambahkan Page Baru

### 1. Buat Route di `routes/web.php`

```php
Route::middleware('auth')->group(function () {
    // ... routes yang sudah ada ...
    
    // Tambahkan route baru
    Route::get('/inventory', function () {
        return view('inventory');
    })->name('inventory');
});
```

### 2. Tambahkan Menu di `config/navigation.php`

Edit file `config/navigation.php` dan tambahkan item menu di array `sidebar`:

```php
'sidebar' => [
    // ... menu yang sudah ada ...
    
    [
        'name' => 'Inventory',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />',
        'route' => 'inventory',
        'active' => 'inventory*',
        'disabled' => false // Set true jika menu belum aktif
    ],
],
```

### 3. Buat View File Baru

Buat file `resources/views/inventory.blade.php`:

```php
@extends('layouts.app')

@php
    $pageTitle = 'Inventory Management';
    $showBackButton = false; // Set true jika ingin tampilkan tombol back
@endphp

@push('styles')
<style>
    /* Custom CSS khusus halaman inventory di sini */
    .inventory-container {
        /* ... styles ... */
    }
</style>
@endpush

@section('content')
    <!-- Konten halaman inventory di sini -->
    <div class="inventory-container">
        <h2>Inventory Management</h2>
        <!-- ... konten lainnya ... -->
    </div>
@endsection

@push('scripts')
<script>
    // Custom JavaScript khusus halaman inventory di sini
    console.log('Inventory page loaded');
</script>
@endpush
```

## Penjelasan Komponen

### Config Navigation (`config/navigation.php`)

Konfigurasi menu dengan properties:
- **name**: Nama menu yang ditampilkan
- **icon**: SVG path untuk icon (gunakan icon dari Heroicons atau sejenisnya)
- **route**: Route name Laravel (harus sesuai dengan `->name()` di routes)
- **active**: Pattern untuk menentukan menu aktif (gunakan wildcard `*` untuk matching)
- **disabled**: Boolean, set `true` untuk menu yang belum aktif (akan ditampilkan tapi disabled)

### Layout Utama (`layouts/app.blade.php`)

- Sudah include sidebar dan topbar secara otomatis
- Mendukung `@push('styles')` untuk custom CSS per halaman
- Mendukung `@push('scripts')` untuk custom JavaScript per halaman
- Menggunakan variabel `$pageTitle` untuk title halaman
- Menggunakan variabel `$showBackButton` untuk menampilkan tombol back

### Sidebar (`partials/sidebar.blade.php`)

- Loop otomatis dari config navigation
- Auto-detect active menu berdasarkan current route
- Support disabled menu
- Include form logout

### Topbar (`partials/topbar.blade.php`)

- Menampilkan page title
- Tombol back (opsional berdasarkan `$showBackButton`)
- Notification button
- User avatar dengan initial

## Tips

### 1. Menambahkan Menu dengan Sub-menu

Jika di masa depan ingin menambahkan sub-menu, bisa extend config dengan struktur nested:

```php
[
    'name' => 'Reports',
    'icon' => '...',
    'route' => 'reports',
    'disabled' => false,
    'children' => [
        [
            'name' => 'Sales Report',
            'route' => 'reports.sales'
        ],
        [
            'name' => 'Inventory Report',
            'route' => 'reports.inventory'
        ]
    ]
]
```

### 2. Custom Icon

Untuk mendapatkan icon SVG path, gunakan:
- [Heroicons](https://heroicons.com/) - Pilih icon, klik "Copy SVG", lalu extract bagian `<path>` nya
- [Feather Icons](https://feathericons.com/) 
- Icon apapun yang compatible dengan SVG

### 3. Conditional Menu

Jika ingin menu hanya muncul untuk role tertentu, tambahkan kondisi di config:

```php
'sidebar' => [
    // ... menu umum ...
    
    @if(auth()->user()->role == 'admin')
    [
        'name' => 'Admin Panel',
        'icon' => '...',
        'route' => 'admin',
        'active' => 'admin*'
    ],
    @endif
],
```

### 4. Override Topbar per Halaman

Bisa override konfigurasi topbar dengan set variable di view:

```php
@php
    $pageTitle = 'My Page';
    $showBackButton = true;
    $notificationCount = 5; // Akan tampilkan badge di notification
@endphp
```

## Keuntungan Sistem Ini

1. ✅ **Tidak Perlu Hardcode**: Semua menu di satu tempat
2. ✅ **Mudah Maintenance**: Ubah menu cukup edit config file  
3. ✅ **Reusable**: Sidebar dan topbar otomatis di semua halaman
4. ✅ **Auto Active State**: Menu aktif terdeteksi otomatis
5. ✅ **Konsisten**: Semua halaman punya struktur yang sama
6. ✅ **Scalable**: Mudah menambah halaman baru tanpa duplicate code

## Troubleshooting

### Menu tidak aktif
- Pastikan `route name` di config sesuai dengan yang di `routes/web.php`
- Pastikan pattern `active` sudah benar (contoh: `menu*` untuk match `menu`, `menu.edit`, dll)

### Icon tidak muncul
- Pastikan SVG path sudah benar (copy dari sumber icon yang valid)
- SVG path harus tanpa `<svg>` wrapper, hanya `<path>` tag nya

### Halaman error 404
- Pastikan route sudah didaftarkan di `routes/web.php`
- Pastikan route name sesuai dengan config navigation

## File Backup

Backup file lama tersimpan di:
- `resources/views/dashboard-old.blade.php`
- `resources/views/menu-old.blade.php`

Bisa dihapus jika sistem baru sudah berjalan dengan baik.
