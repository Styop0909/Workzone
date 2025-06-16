<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function view_login()
    {
        return view("auth.login");
    }


    public function view_register()
    {
        return view("auth.register");
    }

    public function register(Request $request)
    {
        $request->validate([
            'user_type' => 'required|not_in:0',
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $user = User::create([
            'user_role' => 0,
            'user_type' => $request->input("user_type"),
            'name' => $request->input("name"),
            'email' => $request->input("email"),
            'password' => Hash::make($request->input("password")),
        ]);
        if ($user) {
            return redirect()->route("view_login");
        }else{
            return redirect()->back()->withErrors(["error" => "Գրանցման ընթացքում տեղի է ունեցել սխալ"]);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
           'email' => 'required|max:255|exists:users,email',
           'password' => 'required|min:6',
        ]);
        $user = User::query()->where('email', $request->input("email"))->first();
        if ($user) {
            if (Hash::check($request->input("password"), $user->password)) {
                Auth::login($user);
                return redirect()->route("view_dashboard");
            }else{
                return redirect()->back()->with(["error" => "Գաղտնաբառը կամ Էլ․փոստը սխալ է"]);
            }
        }else{
            return redirect()->back()->with(["error" => "Գաղտնաբառը կամ Էլ․փոստը սխալ է"]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("view_login");
    }
}
