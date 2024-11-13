<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource("orders", OrderController::class);
Route::post("webhook", [WebhookController::class, "midtransHandler"]);
