<?php

namespace App\Controllers;

use Core\Routing\Controller;
use Core\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke(): \Core\View\View
    {
        return $this->view('welcome', [
            'data' => 'UCUP LOVE HILMY'
        ]);
    }
}
