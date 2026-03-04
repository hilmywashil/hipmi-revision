<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\OrganisasiController;
use App\Http\Controllers\Admin\KatalogController as AdminKatalogController;
use App\Http\Controllers\Admin\MisiController;
use App\Http\Controllers\Admin\AnggotaManagementController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\UmkmManagementController;
use App\Http\Controllers\Admin\StrategicPlanController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AnggotaAuthController;
use App\Http\Controllers\BukuAnggotaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Admin\KegiatanController as AdminKegiatanController;
use App\Http\Controllers\AnggotaKatalogController;

// =====================================================
// ADMIN ROUTES
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Route yang TIDAK perlu login (guest routes)
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    // Route yang HARUS login (protected with AdminMiddleware)
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        // Dashboard
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Info Admin (BPD only)
        Route::get('info-admin', [AdminDashboardController::class, 'infoAdmin'])->name('info-admin');
        Route::get('create-admin', [AdminDashboardController::class, 'createAdmin'])->name('create-admin');
        Route::post('store-admin', [AdminDashboardController::class, 'storeAdmin'])->name('store-admin');
        Route::get('edit-admin/{admin}', [AdminDashboardController::class, 'editAdmin'])->name('edit-admin');
        Route::put('update-admin/{admin}', [AdminDashboardController::class, 'updateAdmin'])->name('update-admin');
        Route::delete('delete-admin/{admin}', [AdminDashboardController::class, 'deleteAdmin'])->name('delete-admin');

        // ✅ Kegiatan CRUD (Admin)
        Route::resource('kegiatan', AdminKegiatanController::class);

        // ✅ Strategic Plan CRUD (Admin)
        Route::resource('strategic-plan', StrategicPlanController::class);

        // Logout
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

        // Organisasi CRUD (BPD only)
        Route::resource('organisasi', OrganisasiController::class);

        // E-Katalog CRUD (BPD only)
        Route::resource('katalog', AdminKatalogController::class);

        // ✅ TAMBAHKAN 2 BARIS INI (approve & reject)
        Route::post('katalog/{katalog}/approve', [AdminKatalogController::class, 'approve'])->name('katalog.approve');
        Route::post('katalog/{katalog}/reject', [AdminKatalogController::class, 'reject'])->name('katalog.reject');

        // Misi CRUD (BPD only)
        Route::resource('misi', MisiController::class);

        // Berita CRUD (BPD only)
        Route::get('berita', [AdminBeritaController::class, 'index'])->name('berita.index');
        Route::get('berita/create', [AdminBeritaController::class, 'create'])->name('berita.create');
        Route::post('berita', [AdminBeritaController::class, 'store'])->name('berita.store');
        Route::get('berita/{id}/edit', [AdminBeritaController::class, 'edit'])->name('berita.edit');
        Route::put('berita/{id}', [AdminBeritaController::class, 'update'])->name('berita.update');
        Route::delete('berita/{id}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');

        // Anggota Management
        Route::prefix('anggota')->name('anggota.')->group(function () {
            Route::get('/', [AnggotaManagementController::class, 'index'])->name('index');
            Route::get('/list', [AnggotaManagementController::class, 'listAll'])->name('list');

            // ✨ TAMBAHKAN 2 BARIS INI (BARU)
            Route::get('/create', [AnggotaManagementController::class, 'create'])->name('create');
            Route::post('/store', [AnggotaManagementController::class, 'storeByAdmin'])->name('store');

            Route::get('/{anggota}/edit', [AnggotaManagementController::class, 'edit'])->name('edit');
            Route::put('/{anggota}', [AnggotaManagementController::class, 'update'])->name('update');
            Route::post('/{anggota}/reset-password', [AnggotaManagementController::class, 'resetPassword'])->name('reset-password');
            Route::delete('/{anggota}/delete-detail-image', [AnggotaManagementController::class, 'deleteDetailImage'])->name('delete-detail-image');

            Route::get('/{anggota}', [AnggotaManagementController::class, 'show'])->name('show');
            Route::get('/{anggota}/readonly', [AnggotaManagementController::class, 'showReadOnly'])->name('show-readonly');
            Route::post('/{anggota}/approve', [AnggotaManagementController::class, 'approve'])->name('approve');
            Route::post('/{anggota}/reject', [AnggotaManagementController::class, 'reject'])->name('reject');
            Route::delete('/{anggota}', [AnggotaManagementController::class, 'destroy'])->name('destroy');
            Route::get('/{anggota}/promote', [AnggotaManagementController::class, 'promoteToAdmin'])->name('promote');
            Route::post('/{anggota}/promote', [AnggotaManagementController::class, 'storePromotedAdmin'])->name('promote.store');
        });

        // UMKM Management
        Route::prefix('umkm-management')->name('umkm.')->group(function () {
            Route::get('/', [UmkmManagementController::class, 'index'])->name('index');
            Route::get('/export', [UmkmManagementController::class, 'export'])->name('export');
            Route::get('/{umkm}', [UmkmManagementController::class, 'show'])->name('show');
            Route::post('/{umkm}/approve', [UmkmManagementController::class, 'approve'])->name('approve');
            Route::post('/{umkm}/reject', [UmkmManagementController::class, 'reject'])->name('reject');
            Route::delete('/{umkm}', [UmkmManagementController::class, 'destroy'])->name('destroy');
        });
    });
});

// =====================================================
// ANGGOTA AUTH ROUTES
// =====================================================
Route::prefix('anggota')->name('anggota.')->group(function () {
    Route::middleware('guest:anggota')->group(function () {
        Route::get('login', [AnggotaAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AnggotaAuthController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth:anggota')->group(function () {
        Route::post('logout', [AnggotaAuthController::class, 'logout'])->name('logout');
    });
});

// =====================================================
// PUBLIC ROUTES
// =====================================================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// ✅ Strategic Plan Public Route
Route::get('/strategic-plan/{strategicPlan}', [StrategicPlanController::class, 'show'])
    ->name('strategic-plan.detail');

// ✅ Kegiatan Public Routes
Route::get('/informasi-kegiatan', [KegiatanController::class, 'index'])->name('informasi-kegiatan');
Route::get('/informasi-kegiatan/{slug}', [KegiatanController::class, 'show'])->name('detail-kegiatan');

// E-Katalog Public Routes
Route::get('/e-katalog', [KatalogController::class, 'index'])->name('e-katalog');
Route::get('/e-katalog/{katalog}', [KatalogController::class, 'show'])->name('e-katalog.detail');

// Berita Public Routes
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita-detail');

// ✅ TAMBAHKAN BARIS INI - Organisasi Public Routes
Route::get('/organisasi', function () {
    return view('pages.organisasi');
})->name('organisasi');

// ✅ TAMBAHKAN BARIS INI - Route untuk AJAX get detail organisasi
Route::get('/organisasi/{organisasi}', [OrganisasiController::class, 'show'])->name('organisasi.show');

// UMKM Registration
Route::get('/umkm', [UmkmController::class, 'create'])->name('umkm');
Route::post('/umkm', [UmkmController::class, 'store'])->name('umkm.store');

// Jadi Anggota
Route::get('/jadi-anggota', function () {
    if (Auth::guard('anggota')->check()) {
        return redirect()->route('profile-anggota');
    }
    return view('pages.jadi-anggota');
})->name('jadi-anggota');
Route::post('/jadi-anggota', [AnggotaController::class, 'store'])->name('jadi-anggota.store');

// Registration Success Page
Route::get('/registration-success', function () {
    if (!session()->has('generated_password')) {
        return redirect()->route('home');
    }
    return view('pages.registration-success');
})->middleware('auth:anggota')->name('registration-success');

// Profile Anggota Routes
Route::middleware('auth:anggota')->group(function () {
    Route::get('/profile-anggota', [AnggotaController::class, 'profile'])->name('profile-anggota');
    Route::post('/profile-anggota/change-password', [AnggotaController::class, 'changePassword'])->name('profile-anggota.change-password');
    Route::post('/profile-anggota/update-profile', [AnggotaController::class, 'updateProfile'])->name('profile-anggota.update-profile');
    Route::post('/profile-anggota/update-company', [AnggotaController::class, 'updateCompany'])->name('profile-anggota.update-company');
    Route::post('/profile-anggota/upload-detail-images', [AnggotaController::class, 'uploadDetailImages'])->name('profile-anggota.upload-detail-images');
    Route::post('/profile-anggota/delete-detail-image', [AnggotaController::class, 'deleteDetailImage'])->name('profile-anggota.delete-detail-image');
    Route::post('/profile-anggota/change-admin-password', [AnggotaController::class, 'changeAdminPassword'])
        ->name('profile-anggota.change-admin-password');

    // ✅ E-Katalog Management untuk Anggota
    Route::prefix('profile-anggota/katalog')->name('profile-anggota.katalog.')->group(function () {
        Route::get('/', [AnggotaKatalogController::class, 'index'])->name('index');
        Route::get('/create', [AnggotaKatalogController::class, 'create'])->name('create');
        Route::post('/store', [AnggotaKatalogController::class, 'store'])->name('store');
        Route::get('/{katalog}/edit', [AnggotaKatalogController::class, 'edit'])->name('edit');
        Route::put('/{katalog}', [AnggotaKatalogController::class, 'update'])->name('update');
        Route::delete('/{katalog}', [AnggotaKatalogController::class, 'destroy'])->name('destroy');
    });
});

// Buku Anggota Routes
Route::get('/buku-informasi-anggota', [BukuAnggotaController::class, 'index'])->name('buku-anggota');
Route::get('/buku-informasi-anggota/{anggota}', [BukuAnggotaController::class, 'show'])->name('detail-buku');