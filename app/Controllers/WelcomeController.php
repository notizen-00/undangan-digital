<?php

namespace App\Controllers;

use Core\Routing\Controller;
use Core\Http\Request;
use App\Models\User;
class WelcomeController extends Controller
{
    // public function __invoke(): \Core\View\View
    // {
        public function __invoke(): \Core\View\View
        {
            try {
                // Attempt to fetch a user (or any other operation you'd like to perform)
                $user = User::first();
                // dd($user);
                // If the query is successful, pass data to the view
                return $this->view('welcome', [
                    'data' => $user->nama
                ]);
            } catch (\Exception $e) {
                // If an exception is thrown (indicating a database connection issue), handle it
                return $this->view('error', [
                    'error' => 'Failed to connect to the database: ' . $e->getMessage()
                ]);
            }
        }
    // }
}
