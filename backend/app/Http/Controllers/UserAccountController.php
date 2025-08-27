<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class UserAccountController extends Controller
{
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();
    
        DB::transaction(function () use ($user, $validated) {
            $user->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
            ]);
        
            $patientData = [
                'nickname' => $validated['nickname'] ?? null,
                'dob' => $validated['dob'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'address' => $validated['address'] ?? null,
                'occupation' => $validated['occupation'] ?? null,
            ];
        
            if ($user->patient) {
                $user->patient->update($patientData);
            } else {
                $user->patient()->create($patientData);
            }
        
            // Cập nhật lại user từ DB để đảm bảo có patient và role
            $user = $user->fresh(['role', 'patient']);
            $freshPatient = $user->patient;
        
            $hasAllFields = $freshPatient &&
                $freshPatient->dob &&
                $freshPatient->gender &&
                $freshPatient->address &&
                $freshPatient->occupation;
        
                if ($hasAllFields && $user->role->name === 'guest') {
                    $patientRoleId = Cache::rememberForever('role_id_patient', function () {
                        return Role::where('name', 'patient')->value('id');
                    });
                    if ($patientRoleId) {
                        $user->update(['role_id' => $patientRoleId]);
                    }
                }
        });
        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user->load(['role', 'patient']),
        ]);
    }


    
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }
}
