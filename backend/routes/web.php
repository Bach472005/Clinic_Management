<?php

use Illuminate\Support\Facades\Route;
use App\Models\Patient;
use Illuminate\Http\Request;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
        $user = \App\Models\User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link'], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified']);
        }

        $user->markEmailAsVerified();

        // Tạo bản ghi Patient nếu chưa có
        if (!Patient::where('user_id', $user->id)->exists()) {
            Patient::create([
                'user_id' => $user->id,
            ]);
        }
        return response()->json(['message' => 'Email verified successfully']);
    })->name('verification.verify');
});


require __DIR__.'/auth.php';
