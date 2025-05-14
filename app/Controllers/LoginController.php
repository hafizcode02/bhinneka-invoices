<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use Config\Validation;

class LoginController extends BaseController
{
    public function __construct()
    {
        // Load the authentication model
        $this->model = model(User::class);
    }

    public function index()
    {
        // Check if user is already logged in
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        return view('pages/auth/login', [
            'title' => 'Login',
            'page' => 'login',
        ]);
    }

    public function auth()
    {
        $session = session();

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if ($this->validate($rules)) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Check if user exists
            $user = $this->model->where('email', $email)->first();

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Set session data
                    $sessionData = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'role' => $user['role'],
                        'isLoggedIn' => true,
                    ];
                    $session->set($sessionData);

                    return redirect()->to('/dashboard');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
            }
        } else {
            // Validation failed
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to('/login');
    }
}
