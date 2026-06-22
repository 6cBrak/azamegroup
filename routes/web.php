<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

// ─── Public ───────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/produits', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produits/{slug}', [ShopController::class, 'show'])->name('shop.show');

Route::prefix('panier')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/ajouter/{id}', [CartController::class, 'add'])->name('add');
    Route::patch('/modifier/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/supprimer/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/vider', [CartController::class, 'clear'])->name('clear');
});

Route::prefix('commande')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
});

Route::post('/produits/{product}/avis', [ReviewController::class, 'store'])->name('reviews.store');

// ─── Compte client ────────────────────────────────────────────────────────────
Route::prefix('mon-compte')->name('account.')->group(function () {
    Route::get('/connexion',    [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('/connexion',   [CustomerAuthController::class, 'login']);
    Route::get('/inscription',  [CustomerAuthController::class, 'showRegister'])->name('register');
    Route::post('/inscription',  [CustomerAuthController::class, 'register']);
    Route::post('/deconnexion', [CustomerAuthController::class, 'logout'])->name('logout');

    Route::middleware('customer.auth')->group(function () {
        Route::get('/',                [AccountController::class, 'dashboard'])->name('dashboard');
        Route::get('/commandes',       [AccountController::class, 'orders'])->name('orders');
        Route::put('/profil',          [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::put('/mot-de-passe',    [AccountController::class, 'updatePassword'])->name('password.update');
    });
});

Route::get('/faq', [LegalController::class, 'faq'])->name('faq');
Route::get('/conditions-generales', [LegalController::class, 'cgu'])->name('cgu');
Route::get('/politique-de-confidentialite', [LegalController::class, 'privacy'])->name('privacy');

Route::get('/langue/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// ─── Admin ────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class)->names('products');
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('orders', OrderController::class)->names('orders')->only(['index', 'show', 'update', 'destroy']);

        Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::delete('contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
        Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::delete('products/{product}/images/{index}', [ProductController::class, 'removeImage'])->name('products.images.destroy');
        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

        // Réservé aux admins uniquement
        Route::middleware('require.admin')->group(function () {
            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
            Route::post('profile/users', [ProfileController::class, 'storeUser'])->name('profile.users.store');
            Route::delete('profile/users/{user}', [ProfileController::class, 'destroyUser'])->name('profile.users.destroy');
        });
    });
});
