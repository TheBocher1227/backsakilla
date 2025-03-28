<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mail\TwoFactorCodeMail;

class AuthController extends Controller
{
    public function loginStep1(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $staff = Staff::where('email', $request->email)->first();

        if (!$staff || !Hash::check($request->password, $staff->password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        TwoFactorCode::where('staff_id', $staff->staff_id)->delete(); 

        $twoFactorCode = TwoFactorCode::create([
            'staff_id' => $staff->staff_id,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(10)
        ]);

        Mail::to($staff->email)->send(new TwoFactorCodeMail($code));

        return response()->json(['message' => 'Código de verificación enviado']);
    }

    public function loginStep2(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ]);

        $staff = Staff::where('email', $request->email)->first();

        if (!$staff) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $twoFactorCode = TwoFactorCode::where('staff_id', $staff->staff_id)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->where('used', false)
            ->first();

        if (!$twoFactorCode) {
            return response()->json(['error' => 'Código inválido o expirado'], 401);
        }

        
        $twoFactorCode->update(['used' => true]);

        $token = JWTAuth::fromUser($staff);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }
}