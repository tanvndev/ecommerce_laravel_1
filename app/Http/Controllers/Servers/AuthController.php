<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct() {}

    public function index()
    {
        return view('servers.auth.login');
    }

    function login(AuthRequest $request)

    {
        // Cai nay dung de kiem tra thong tin dang nhap voi database
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.index')->with('toast_success', 'Đăng nhập thành công.');
        }
        return redirect()->back()->with('toast_error', 'Email hoặc mật khẩu không chính xác.');
    }

    public function register()
    {
        return view('servers.auth.register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // Tìm parent_id từ referral_code (nếu có)
            $parent_id = null;
            if ($request->referral_code) {
                $parent = User::where('referral_code', $request->referral_code)->first();
                if ($parent) {
                    $parent_id = $parent->id;
                }
            }
            // Tạo user mới
            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'parent_id' => $parent_id,
                'phone' => time(),
                'user_catalogue_id' => 2,
            ]);

            DB::commit();

            return redirect()->route('auth.login.index')->with('toast_success', 'Đăng ký thành công.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->with('toast_error', 'Đăng ký thất bại.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('auth.admin'));
    }
}
