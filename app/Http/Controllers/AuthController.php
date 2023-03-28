<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\User;


class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];

        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            $user = User::where('email', $request->input('email'))->first();
            $user->setSetting('tahun', '2023');
            // $user->setSettings(['first_name' => 'John', 'last_name' => 'Smith']);
            if ($user->avatar == null) {
                $user->avatar = 'https://community.bps.go.id/images/nofoto.JPG';
                $user->save();
            }

            //kembalikan  ke link awal

            if ($user->role_id == 6) {
                $email = $user->email;
                $name = $user->name;
                Auth::logout();
                return view('403', compact('name', 'email'));
            } else {
                if (Session::has('url.intended')) {
                    return redirect()->intended();
                } else {
                    return redirect()->route('dashboard');
                }
            }

            //return redirect()->route('dashboard');
        } else { // false

            //Login Fail
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('xlogin');
    }
}
