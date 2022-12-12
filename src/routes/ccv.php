<?php

use ModularCCV\ModularCCV\Controllers\PaymentController;
use ModularCCV\ModularCCV\Controllers\NotificationController;
use ModularCCV\ModularCCV\Controllers\InstallController;
use ModularCCV\ModularCCV\Controllers\WebhookController;
use ModularCCV\ModularCCV\Controllers\RedirectController;
use ModularCCV\ModularCCV\Controllers\RefundController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'CCV',
    'as' => 'CCV.',
    'middleware' => ['web']
], function () {
    //Setup Route
    Route::post('/install', InstallController::class)->name('install');

    Route::post('/uninstall', InstallController::class)->name('uninstall');

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
