<?php

namespace Config;

class Auth extends \Myth\Auth\Config\Auth
{
    public $views = [
        'login'           => 'Myth\Auth\Views\login',
        'register'        => 'auth/register',
        'forgot'          => 'Myth\Auth\Views\forgot',
        'reset'           => 'Myth\Auth\Views\reset',
        'emailForgot'     => 'Myth\Auth\Views\emails\forgot',
        'emailActivation' => 'Myth\Auth\Views\emails\activation',
    ];
    public $viewLayout        = 'layouts/public';
    public $allowRegistration = true;
    public $allowRemembering  = true;
    public $rememberLength    = 30 * DAY;
    public $personalFields    = ['firstname', 'lastname'];
}
