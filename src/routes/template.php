<?php

use ModularTemplate\ModularTemplate\Controllers\PaymentController;
use ModularTemplate\ModularTemplate\Controllers\NotificationController;
use ModularTemplate\ModularTemplate\Controllers\InstallController;
use ModularTemplate\ModularTemplate\Controllers\WebhookController;
use ModularTemplate\ModularTemplate\Controllers\RedirectController;
use ModularTemplate\ModularTemplate\Controllers\RefundController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'template',
    'as' => 'template.',
    'middleware' => ['web']
], function () {
    //Installation Route
    Route::post('/install', InstallController::class)->name('install');

    //Payment Route
    Route::post('/payment', PaymentController::class)->name('payment');

    //Redirect Route
    Route::post('/webhook', RedirectController::class)->name('process.void');

    //Notification Route
    Route::post('/notification', NotificationController::class)->name('process.capture');

    //Refund Route
    Route::post('/refund', RefundController::class)->name('refund');

    //Webhook Route
    Route::post('/webhook', WebhookController::class)->name('process.void');

});
