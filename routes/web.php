<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Nexus: E-commerce Dashboard (public)
Route::get('/dashboards-ecommerce', function () {
    return Inertia::render('Nexus/Dashboards/Ecommerce');
})->name('nexus.dashboard.ecommerce');

// Nexus: More dashboards
Route::get('/dashboards-crm', fn() => Inertia::render('Nexus/Dashboards/Crm'))->name('nexus.dashboard.crm');
Route::get('/dashboards-gen-ai', fn() => Inertia::render('Nexus/Dashboards/GenAi'))->name('nexus.dashboard.genai');

// Nexus: Apps
Route::get('/apps-chat', fn() => Inertia::render('Nexus/Apps/Chat'))->name('nexus.apps.chat');
Route::get('/apps-ecommerce-orders', fn() => Inertia::render('Nexus/Apps/Ecommerce/Orders'))->name('nexus.apps.ecommerce.orders');
Route::get('/apps-ecommerce-products', fn() => Inertia::render('Nexus/Apps/Ecommerce/Products'))->name('nexus.apps.ecommerce.products');
Route::get('/apps-ecommerce-sellers', fn() => Inertia::render('Nexus/Apps/Ecommerce/Sellers'))->name('nexus.apps.ecommerce.sellers');
Route::get('/apps-ecommerce-customers', fn() => Inertia::render('Nexus/Apps/Ecommerce/Customers'))->name('nexus.apps.ecommerce.customers');
Route::get('/apps-ecommerce-shops', fn() => Inertia::render('Nexus/Apps/Ecommerce/Shops'))->name('nexus.apps.ecommerce.shops');
Route::get('/apps-file-manager', fn() => Inertia::render('Nexus/Apps/FileManager'))->name('nexus.apps.filemanager');

// Nexus: Gen AI pages
Route::get('/apps-gen-ai-home', fn() => Inertia::render('Nexus/GenAI/Home'))->name('nexus.genai.home');
Route::get('/apps-gen-ai-content', fn() => Inertia::render('Nexus/GenAI/Content'))->name('nexus.genai.content');
Route::get('/apps-gen-ai-image', fn() => Inertia::render('Nexus/GenAI/Image'))->name('nexus.genai.image');
Route::get('/apps-gen-ai-library', fn() => Inertia::render('Nexus/GenAI/Library'))->name('nexus.genai.library');

// Nexus: Pages
Route::get('/pages-settings', fn() => Inertia::render('Nexus/Pages/Settings'))->name('nexus.pages.settings');

// Nexus: Agentic Hub
Route::get('/agentic-storage', fn() => Inertia::render('Nexus/Agentic/Storage'))->name('nexus.agentic.storage');


// Nexus: Landing
Route::get('/landing', fn() => Inertia::render('Nexus/Landing'))->name('nexus.landing');

Route::get('/pages-get-help', fn() => Inertia::render('Nexus/Pages/GetHelp'))->name('nexus.pages.gethelp');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
