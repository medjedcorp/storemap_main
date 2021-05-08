<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered; // 追加登録のメール送信
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:seller,user'], // 追加
        ]);
    }

    protected function create(array $data)
    {

        // dd($data);
        $data_value = $data['role'];
        $user_value = 'user';
        $seller_value = 'seller';
        if (($data_value == $user_value) or ($data_value == $seller_value)) {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],  // 追加
                'password' => Hash::make($data['password']),
            ]);
        } else {
            abort(500);
        }
    }

    // 追加
    public function showUserRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }
        // 一般用のログイン画面へ飛ばす
        return view('vendor.adminlte.auth.user-register');
    }
    // 追加
    public function showSellerRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }
        // セラー用のログイン画面へ飛ばす
        return view('vendor.adminlte.auth.seller-register');
    }
}
