<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
    CustomerController,
    DesignController,
    MeasurementController,
    MessageController,
    SyncQueueController
};

Route::prefix('v1')->group(function () {

    // Customers
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'getAllCustomers']);
        Route::post('/', [CustomerController::class, 'createCustomer']);
        Route::get('/{id}', [CustomerController::class, 'getCustomer']);
        Route::put('/{id}', [CustomerController::class, 'updateCustomer']);
        Route::delete('/{id}', [CustomerController::class, 'deleteCustomer']);
    });

    // Designs
    Route::prefix('designs')->group(function () {
        Route::get('/', [DesignController::class, 'getAllDesigns']);
        Route::post('/', [DesignController::class, 'createDesign']);
        Route::get('/{id}', [DesignController::class, 'getDesign']);
        Route::put('/{id}', [DesignController::class, 'updateDesign']);
        Route::delete('/{id}', [DesignController::class, 'deleteDesign']);

        // delete a photo
        Route::delete('/design-photos/{photoId}', [DesignController::class, 'deleteDesignPhoto']);
    });

    // Measurements
    Route::prefix('measurements')->group(function () {
        Route::get('/', [MeasurementController::class, 'getAllMeasurements']);
        Route::post('/', [MeasurementController::class, 'createMeasurement']);
        Route::get('/{id}', [MeasurementController::class, 'getMeasurement']);
        Route::put('/{id}', [MeasurementController::class, 'updateMeasurement']);
        Route::delete('/{id}', [MeasurementController::class, 'deleteMeasurement']);

        // Measurements by Customer UUID
        Route::get('/customer/{id}', [MeasurementController::class, 'getCustomerMeasurements']);
    });

    // Messages
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageController::class, 'getAllMessages']);
        Route::post('/', [MessageController::class, 'createMessage']);
        Route::get('/{id}', [MessageController::class, 'getSingleMessage']);
        Route::put('/{id}', [MessageController::class, 'updateMessage']);
        Route::delete('/{id}', [MessageController::class, 'deleteMessage']);
    });

    // Sync Queue
    Route::prefix('sync-queue')->group(function () {
        Route::get('/', [SyncQueueController::class, 'getAllSyncQueueRecords']);
        Route::post('/', [SyncQueueController::class, 'createSyncQueueRecord']);
        Route::put('/{id}', [SyncQueueController::class, 'updateSyncQueueRecord']);
        Route::delete('/{id}', [SyncQueueController::class, 'deleteSyncQueueRecord']);
    });
});
