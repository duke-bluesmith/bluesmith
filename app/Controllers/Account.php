<?php

namespace App\Controllers;

class Account extends BaseController
{
    // Displays a list of jobs for the current user
    public function jobs()
    {
        return view('account/jobs', ['jobs' => user()->jobs]);
    }
}
