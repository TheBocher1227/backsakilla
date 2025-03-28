<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mail\TwoFactorCodeMail;

class AuthController extends Controller
{
    public function loginStep1(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $staff = Staff::where('email', $request->email)->first();
        if (!$staff) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
        if (!Hash::check($request->password, $staff->password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $staff->code = $code;
        $staff->save();

        Mail::to($staff->email)->send(new TwoFactorCodeMail($code));

        return response()->json(['message' => 'Código de verificación enviado'],);
    }

    public function loginStep2(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|string'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $staff = Staff::where('email', $request->email)->first();

        if (!$staff) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if($staff->code != $request->code){
            return response()->json(['error' => 'Código de verificación inválido'], 403);
        }
        if(!$token = JWTAuth::fromUser($staff)){
            return response()->json(['error' => 'Error al crear el token'], 403);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'staff' => $staff

        ]);
    }
}
