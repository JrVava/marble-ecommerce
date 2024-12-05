<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // dd($user->status);
            if ($user->status) {
                if ($user->getRoleNames()->count() > 0) {
                    return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
                }
                $intendedUrl = session('url.intended', url('/'));
                return redirect($intendedUrl);
            }else{
                Session::flush();
                Auth::logout();
                return redirect()
                    ->route('login')
                    ->withErrors([
                        'error' => 'Opps! Inactive user please contact to admin.'
                    ]);

            }
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
