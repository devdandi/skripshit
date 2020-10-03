<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\City;
use App\Customer;

class LoginController extends Controller
{
    public function loginForm()
    {
        if (auth()->guard('customer')->check()) return redirect(route('customer.dashboard'));
        return view('ecommerce.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|string'
        ]);

    $auth = $request->only('email', 'password');
    $auth['status'] = 0; 

    if (auth()->guard('customer')->attempt($auth)) {
        return redirect()->intended(route('customer.dashboard'));
    }
    return redirect()->back()->with(['error' => 'Email / Password Salah']);
    }

    public function dashboard()
    {
        return view('ecommerce.dashboard');
    }
    public function logout()
    {
        auth()->guard('customer')->logout();
        return redirect(route('customer.login'));
    }
    public function register()
    {
        return view('ecommerce.register', ['city' => City::all()]);
    }
    public function post_register(Request $req)
    {
        $register = Customer::register($req->nama, $req->email, $req->password, $req->alamat, $req->city);
        if($register === true)
        {
            $req->session()->put(['login', $req->email]);
            return redirect('/customer/dashboard');
        }else{
            return back()->with(['error' => 'Something went wrong !']);
        }
    }
}