<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\clientes\ClientesController;
use App\Http\Controllers\pagos\PagosController;
use App\Http\Controllers\crm\CrmController;
use App\Http\Controllers\usuarios\UsuariosController;
use App\Http\Controllers\portal\PortalController;
use App\Http\Controllers\LandingController;

// Template demo controllers (optional Sneat UI components)
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;

/*
|--------------------------------------------------------------------------
| Landing Page Pública de Club Polanco
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Autenticación de Usuarios del Sistema (Admin & Operador)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/debug-hash', function () {
    $info = [
        'php_version' => PHP_VERSION,
        'hashing_config' => config('hashing'),
    ];
    try {
        $info['native_cost_10'] = password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 10]);
    } catch (\Throwable $e) {
        $info['native_cost_10_err'] = get_class($e) . ': ' . $e->getMessage();
    }
    try {
        $info['laravel_hash'] = \Illuminate\Support\Facades\Hash::make('admin123');
    } catch (\Throwable $e) {
        $info['laravel_hash_err'] = get_class($e) . ': ' . $e->getMessage();
    }
    return response()->json($info);
});

/*
|--------------------------------------------------------------------------
| Portal Exclusivo de Socios (Acceso por Código + Fecha de Nacimiento)
|--------------------------------------------------------------------------
*/
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', [PortalController::class, 'showLogin'])->name('login');
    Route::post('/login', [PortalController::class, 'login'])->name('login.submit');
    Route::get('/logout', [PortalController::class, 'logout'])->name('logout');

    // Rutas protegidas para el socio en sesión
    Route::middleware('socio.auth')->group(function () {
        Route::get('/inicio', [PortalController::class, 'inicio'])->name('inicio');
        Route::get('/historial', [PortalController::class, 'historial'])->name('historial');
        Route::get('/pagar', [PortalController::class, 'pagar'])->name('pagar');
        Route::post('/pagar/tarjeta', [PortalController::class, 'procesarTarjeta'])->name('pagar.tarjeta');
        Route::post('/pagar/qr', [PortalController::class, 'procesarQr'])->name('pagar.qr');
        Route::get('/recibo/{pago}', [PortalController::class, 'recibo'])->name('recibo');
    });
});

/*
|--------------------------------------------------------------------------
| Panel Administrativo de Club Polanco (Requiere Login de Sistema)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // 1. Dashboard Principal
    Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard-analytics');

    // 2. Cartera de Socios
    Route::resource('clientes', ClientesController::class)->parameters(['clientes' => 'socio']);

    // 3. Gestión de Pagos
    Route::prefix('pagos')->name('pagos.')->group(function () {
        Route::get('/', [PagosController::class, 'index'])->name('index');
        Route::get('/qr', [PagosController::class, 'qr'])->name('qr');
        Route::post('/qr', [PagosController::class, 'storeQr'])->name('qr.store');
        Route::get('/tarjeta', [PagosController::class, 'tarjeta'])->name('tarjeta');
        Route::post('/tarjeta', [PagosController::class, 'storeTarjeta'])->name('tarjeta.store');
        Route::get('/verificacion', [PagosController::class, 'verificacion'])->name('verificacion');
        Route::post('/{pago}/aprobar', [PagosController::class, 'aprobar'])->name('aprobar');
        Route::post('/{pago}/rechazar', [PagosController::class, 'rechazar'])->name('rechazar');
        Route::get('/recibos', [PagosController::class, 'recibos'])->name('recibos');
        Route::get('/recibo/{pago}', [PagosController::class, 'showRecibo'])->name('recibo.show');
        Route::get('/cobranza-automatica', [PagosController::class, 'cobranzaAutomatica'])->name('cobranza-automatica');
        Route::post('/cobranza-automatica/ejecutar', [PagosController::class, 'ejecutarCobranzaAutomatica'])->name('cobranza.ejecutar');
    });

    // 4. CRM / WhatsApp
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::get('/mensajes', [CrmController::class, 'mensajes'])->name('mensajes');
        Route::post('/mensajes', [CrmController::class, 'storeMensaje'])->name('mensajes.store');
        Route::get('/automatizacion', [CrmController::class, 'automatizacion'])->name('automatizacion');
        Route::post('/automatizacion/ejecutar', [CrmController::class, 'ejecutarAutomatizacion'])->name('automatizacion.ejecutar');
        Route::get('/recordatorios', [CrmController::class, 'recordatorios'])->name('recordatorios');
    });

    // 5. Perfil de Usuario en Sesión
    Route::get('/usuarios/perfil', [UsuariosController::class, 'perfil'])->name('usuarios.perfil');
    Route::put('/usuarios/perfil', [UsuariosController::class, 'updatePerfil'])->name('usuarios.perfil.update');

    // 6. Gestión de Usuarios del Sistema (Solo Administradores)
    Route::middleware('role:admin')->group(function () {
        Route::resource('usuarios', UsuariosController::class)->except(['show'])->parameters(['usuarios' => 'usuario']);
    });

    // Template UI demo pages (compatibilidad con la plantilla Sneat)
    Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
    Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
    Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
    Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
    Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
    Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');
    Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
    Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
    Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
    Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
    Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
    Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
    Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
    Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
    Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
    Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
    Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
    Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
    Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
    Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
    Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
    Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
    Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
    Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
    Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');
    Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
    Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');
    Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');
    Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
    Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');
    Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
    Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
    Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
});