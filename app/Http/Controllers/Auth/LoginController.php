<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function username()
    {
        return 'nisn'; // pakai kolom nisn untuk login
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect($this->redirectToBasedOnRole($user));
    }

    protected function redirectToBasedOnRole($user)
    {
        switch ($user->role) {
            case 'superadmin':
                return route('superadmin.dashboard'); // Sesuaikan dengan route yang ada

            case 'orangtua':
                return route('ortu.dashboard'); // Sesuaikan dengan route yang ada

            default:
                return route('welcome'); // Redirect default jika level tidak sesuai
        }
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }
}
