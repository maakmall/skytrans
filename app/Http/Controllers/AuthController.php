<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function index()
    {
        return view('auth.index');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()
            ->withErrors(['login' => 'Username atau Password Tidak Valid'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function register(UserRequest $request)
    {
        $user = User::create($request->validated());

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Selamat Datang',
            'description' => 'Registrasi user berhasil, mohon lengkapi data dibagian registrasi',
            'icon' => 'fa-home',
            'color' => 'danger',
            'link' => '/registration'
        ]);

        return response()->json([
            'message' => 'Registrasi Berhasil. Silahkan login!'
        ]);
    }

    public function forgotPassword()
    {
        return view('auth.forgot');
    }

    public function reset(Request $request)
    {
        $data = $request->validate(
            ['username' => 'required|exists:users'],
            [
                'username.required' => 'Username Tidak Boleh Kosong',
                'username.exists' => 'Username Tidak Terdaftar'
            ]
        );

        $user = User::where('username', $data['username'])->first();

        Notification::create([
            'user_id' => User::where('is_admin', true)->first()->id,
            'title' => 'Reset Password',
            'description' => "$user->username meminta untuk reset password",
            'icon' => 'fa-key',
            'color' => 'warning',
            'link' => "/users/$user->id/edit",
        ]);

        return response()->json([
            'message' =>
            'Permintaan reset passsword berhasil. Mohon tunggu konfirmasi dari admin'
        ]);
    }

}
