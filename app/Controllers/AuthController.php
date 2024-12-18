<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected $auth;
    protected $config;
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
        $this->config = config('Auth');
        $this->auth   = service('authentication');
    }

    public function login() 
    {
        if ($this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/home');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }
        return view('auth/login');
    }
    public function reg()
    {
        if ($this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/home');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }
        return view('auth/register');
    }

    public function forgotPassword(){
        return view('auth/resetPassword');
    }

    public function resetPassword(){
        $token = $this->request->getGet('token');

        return view('auth/formReset', 
                    ['token' => $token]
        );
    }

    public function loginSuccess()
    {
        if(in_groups('admin')){
            return redirect()->to('/admin');
        }
        return view('user/indexLogin');
    }
}
