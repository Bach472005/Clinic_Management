<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar_url' => 'avatar-mac-dinh-1.webp',
        ]);
        
        $user->sendEmailVerificationNotification();
        
        return response()->json([
            'message' => 'Sign up successfully',
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            // thêm các trường cần thiết
        ]);
    }

    public function login(Request $request) {
        // Validate dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        // Xác thực thông tin người dùng
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $relations = ['role'];
            
            if ($user->role->name === 'patient') {
                $relations[] = 'patient';
            } elseif ($user->role->name === 'psychologist') {
                $relations[] = 'psychologist';
            }
            $user->load($relations);
            // Tạo token
            $token = $user->createToken('ClinicManagement')->plainTextToken;
            
            return response()->json([
                'message' => 'Login successfully',
                'token' => $token,
                'user' => $user
            ]);
        }
    
        return response()->json([
            'errors' => [
                'password' => 'Wrong password or email'
            ]
        ], 422);
    }
    

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return response()->json(Auth::user());
    }
}
