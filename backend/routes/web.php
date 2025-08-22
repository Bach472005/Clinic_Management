<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

        return response()->json(['message' => 'Email verified successfully']);
    })->name('verification.verify');
});

// Route::get('/email/verify', function (Request $request) {
//     return response()->json([
//         'message' => 'Email not verified.',
//         'verified' => $request->user()?->hasVerifiedEmail() ?? false
//     ]);
// })->middleware('auth:sanctum')->name('verification.notice');

// Route::post('/email/verification-notification', function (Request $request) {
//     if ($request->user()->hasVerifiedEmail()) {
//         return response()->json([
//             'message' => 'Email already verified.'
//         ], 400);
//     }

//     $request->user()->sendEmailVerificationNotification();

//     return response()->json([
//         'message' => 'Verification email sent.'
//     ]);
// })->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');


require __DIR__.'/auth.php';
