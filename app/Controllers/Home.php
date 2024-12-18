<?php

namespace App\Controllers;
use Myth\Auth\Models\UserModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\FeedbacksModel;
use Config\Services;

class Home extends BaseController
{
    protected $auth;
    protected $session;
    public function __construct()
    {
        $this->session = service('session');
        $this->auth   = service('authentication');
    }
    public function index()
    {
        if ($this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/home');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }
        return view('index');
    }
}