<?php
/**
 * File name: RegisterController.php
 * Last modified: 2020.05.27 at 18:36:53
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\UploadRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/verify';

    private $userRepository;
    private $uploadRepository;
    private $roleRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, UploadRepository $uploadRepository, RoleRepository $roleRepository)
    {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
        $this->uploadRepository = $uploadRepository;
        $this->roleRepository = $roleRepository;
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:15|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'verification_code' => 'required',
            'country' => 'required',
            'role' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return
     */
    protected function create(array $data)
    {
        $user = new User;
        $user->name =  $data['name'];
        $user->email =  $data['email'];
        $user->phone =  $data['phone'];
        $user->country =  $data['country'];
        $user->password = Hash::make($data['password']);
        $user->api_token = str_random(60);
        $user->save();
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-public.mtarget.fr/messages",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "username=jmjafrica&password=wcuvTCmq&msisdn=00237".$data['phone']."&msg=Activation code ".$data['verification_code']."&allowunicode=true&sender=Spideli",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);*/
        if($data['role']=3){
            $defaultRoles = $this->roleRepository->findByField('default', '2');
        }
        else{
            $defaultRoles = $this->roleRepository->findByField('default', '1');
        }
        $defaultRoles = $defaultRoles->pluck('name')->toArray();
        $user->assignRole($defaultRoles);

        Session::put('phonenumberSession',$data['phone']);
        Session::put('verificationcodeSession',$data['verification_code']);
        return $user;
    }

}
