<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    //login admin
    public function login_admin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or Password is wrong!'], 401);
        }

        // Fetch autentikasi user email dan id
        $user = auth()->user();
        $customClaims = [
            'email' => $user->email,
            'id' => $user->id,
            'role' => 'admin', // Menganggap semua user yang login melalui endpoint ini adalah admin
        ];
        // Generate token baru
        $token = JWTAuth::claims($customClaims)->attempt($credentials);

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
//registrasi Member baru
    public function register(Request $request){
        //validasi request
        $validator = Validator::make($request->all(), [
            'nama_member' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required|same:password'
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        };
        //bcrypt password agar lebih aman dan tidak memperlihatkan password sebenarnya
        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        unset($input['konfirmasi_password']);
        $member = Member::create($input);

        return response()->json([
            'data' => $member
        ]);
    }
        public function logout(){
        auth()->logout();
        //Menampilkan pesan 'Succesfully Logout' ketika berhasil logout
        return response()->json(['message' => 'Successfully Logout']);
    }
 
}



