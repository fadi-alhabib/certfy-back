<?php

use Illuminate\Support\Facades\Route;

Route::get('/*', function () {
    return redirect("https://certfy.me", secure: true);
});
Route::get('/storage/{folder}/{filename}', function ($folder, $filename) {
    $path = storage_path('app/public/' . $folder . '/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});
