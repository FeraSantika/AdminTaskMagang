<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\DataUser;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Verifytoken;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/admin/home';

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
            'password' => [
                'required', 'string','min:6','confirmed','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            ],
            'password_confirmation' => ['required','same:password']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user = DataUser::create([
            'User_name' => $data['name'],
            'User_email' => $data['email'],
            'User_gender' => $data['gender'],
            'Role_id' => 3,
            'User_password' => Hash::make($data['password']),
        ]);

        // $validToken = rand(10, 100.. '2022');
        // $get_token = new Verifytoken();
        // $get_token->token = $validToken;
        // $get_token->email = $data['email'];
        // $get_token->save();
        // $get_user_email = $data['email'];
        // $get_user_name = $data['name'];
        // Mail::to($data['email'])->send(new WelcomeMail($get_user_email, $validToken, $get_user_name));

        return $user;
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }
}
