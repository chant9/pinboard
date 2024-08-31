<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
], function () {
    Route::get('articles', [ApiController::class, 'articles'])->name('api.articles');
    Route::get('tags', [ApiController::class, 'tags'])->name('api.tags');
});
