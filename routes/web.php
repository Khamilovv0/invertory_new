<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\backend\{ForQrCodeController, ToPdfController, WriteOffController, ImportController,CategoryController, UserController,SynchronizeController, DitInvertoryController,DahrInvertoryController,MoveAndChangeController, AllDatabaseController, PropertiesController};
use App\Http\Controllers\Auth\LoginController;

    Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class,'authenticate']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/authenticateViaToken', [LoginController::class, 'authenticateViaToken'])->name('authenticateViaToken');
    Route::get('/saveToken', [LoginController::class, 'saveToken'])->name('saveToken');

    //Типа роли так организовал(эти ссылки открываются только разрешенным пользователям)
    Route::middleware('checkuserid')->group(function () {
        Route::get('list_name', [CategoryController::class, 'CategoryList'])->name('category');
        Route::get('/add_name', [CategoryController::class, 'CategoryAdd'])->name('categoryadd');
        Route::post('/insert_name', [CategoryController::class, 'CategoryInsert'])->name('categoryinsert');
        Route::get('/edit_name/{id}', [CategoryController::class, 'EditCategory'])->name('EditCategory');
        Route::post('/update_name/{id}', [CategoryController::class, 'UpdateCategory'])->name('UpdateCategory');
        Route::get('/delete_name/{id}', [CategoryController::class, 'DeleteCategory'])->name('DeleteCategory');

        Route::get('list_properties', [PropertiesController::class, 'ProperityList'])->name('properties');
        Route::get('/add_properties', [PropertiesController::class, 'ProperityAdd'])->name('propertiesadd');
        Route::post('/insert_properties', [PropertiesController::class, 'ProperityInsert'])->name('propertiesinsert');
        Route::get('/edit_properties/{id}', [PropertiesController::class, 'EditProperity'])->name('EditProperity');
        Route::post('/update_properties/{id}', [PropertiesController::class, 'UpdateProperity'])->name('UpdateProperity');
        Route::get('/delete_properties/{id}', [PropertiesController::class, 'DeleteProperity'])->name('DeleteProperity');

        Route::get('/synchronize', [SynchronizeController::class, 'synchronize'])->name('synchronize');
        Route::post('/synchronize_complete', [SynchronizeController::class, 'synchronize_complete'])->name('synchronize_complete');

        Route::get('/write_off', [WriteOffController::class,'write_off'])->name('write_off');
        Route::post('/write_off_save', [WriteOffController::class,'write_off_save'])->name('write_off_save');
        Route::get('/write_off_list', [WriteOffController::class,'write_off_list'])->name('write_off_list');
        Route::get('/doc_view/{id}', [WriteOffController::class,'doc_view'])->name('doc_view');

        Route::get('/export', [AllDatabaseController::class,'export'])->name('export');
        Route::get('/for_qr_inv', [ForQrCodeController::class,'for_qr_list_inv'])->name('for_qr_list_inv');
        Route::get('/for_qr_auditory', [ForQrCodeController::class,'for_qr_list_auditory'])->name('for_qr_list_auditory');
        Route::post('/qr_pdf_inv', [ForQrCodeController::class,'qr_generate_inv'])->name('qr_generate_inv');
        Route::post('/qr_pdf_auditory', [ForQrCodeController::class,'qr_generate_auditory'])->name('qr_generate_auditory');
        Route::get('/scan', [ForQrCodeController::class,'qr_scan'])->name('qr_scan');
    });
    //Ссылки доступные всем пользователям
    Route::get('/dit_create', [DitInvertoryController::class,'CreateDit'])->name('createDit');

    Route::get('/get-product-form/{id}', [DitInvertoryController::class,'getForm'])->name('getForm');
    Route::post('/dit_create/addAll', [DitInvertoryController::class,'addAll'])->name('addAll');
    Route::get('/get-auditories/{building}', [DitInvertoryController::class,'forBuilding'])->name('forBuilding');

    Route::get('/dahr_create', [DahrInvertoryController::class,'CreateDahr'])->name('createDahr');

    Route::get('/all', [AllDatabaseController::class,'all'])->name('all');
    Route::get('/filter', [AllDatabaseController::class,'filter'])->name('filter');
    Route::get('/noSorted', [AllDatabaseController::class,'noSorted'])->name('noSorted');
    Route::get('/noNumber', [AllDatabaseController::class,'noNumber'])->name('noNumber');

    Route::get('/all/{id}', [MoveAndChangeController::class,'editAll'])->name('editAll');
    Route::post('/all/{id_product}', [MoveAndChangeController::class, 'updateAll'])->name('updateAll');
    Route::post('/all/confirm/{id}', [MoveAndChangeController::class,'confirmStatus'])->name('confirmStatus');
    Route::post('/all/refuse/{id}', [MoveAndChangeController::class,'refuseStatus'])->name('refuseStatus');
    Route::get('/get-product-form/{id}', [MoveAndChangeController::class,'getForm'])->name('getForm');
    Route::get('/change', [MoveAndChangeController::class,'change_tutor'])->name('change_tutor');
    Route::get('/search', [MoveAndChangeController::class, 'search_item'])->name('search_item');
    Route::get('/edit/{id}', [MoveAndChangeController::class,'editChange'])->name('editChange');
    Route::post('/insert/{id}', [MoveAndChangeController::class,'insert'])->name('insert');
    Route::get('/story/{id}', [MoveAndChangeController::class,'story'])->name('story');
    Route::get('/doc_view/{id}', [MoveAndChangeController::class,'move_view'])->name('move_view');

    Route::post('/import', [ImportController::class, 'import'])->name('import');

    Route::get('/open_pdf', [ToPdfController::class, 'open_pdf'])->name('open_pdf');

    Route::post('/generate-pdf', [ToPdfController::class, 'generatePdf'])->name('generate.pdf');



Route::middleware([])->group(function () {
    Route::get('/qr_scan_list/{id_product}', [ForQrCodeController::class,'qr_scan_list'])->name('qr_scan_list');
});
