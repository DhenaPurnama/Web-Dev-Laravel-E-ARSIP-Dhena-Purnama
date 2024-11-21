<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    class LoginController extends Controller
    {
        public function index()
        {
            return view('auth.login',[
                'title' => 'Login'
            ]);
        }

        public function admincreate()
        {
            User::create([
                'name' => 'Dhena',
                'email' => 'Dhena@xample.com',
                'password' => Hash::make('Dhena185'),
            ]);
            return response()->json(['success' => 'Berhasil']);

        }

        public function authenticate(Request $request)
        {
            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            if(Auth::attempt($credentials))
            {
                $request->session()->regenerate();
                return redirect()->intended('admin/dashboard');
            }

            return back()->with('loginError', 'Login Failed!');
        }

        public function logout(Request $request)
        {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/');
        }
    }
