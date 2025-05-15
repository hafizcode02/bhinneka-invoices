<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{

    public function __construct()
    {
        $this->model = model(User::class);
    }

    public function index()
    {
        // Code
    }

    public function getProfile()
    {
        $userData = $this->model->find(session()->get('id'));
        // dd($userData);
        return view('pages/profile/index', [
            'user' => $userData,
            'title' => 'Akun Profile',
        ]);
    }

    public function updateProfile()
    {
        // Get user ID from session
        $userId = session()->get('id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Set validation rules
        $rules = [
            'name' => 'required|min_length[3]',
        ];

        // Add password validation rules if password is not empty
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'required|min_length[6]';
            $rules['password_confirmation'] = 'required|matches[password]';
        }

        // Validate input
        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        try {
            // Prepare data for update
            $updateData = [
                'name' => $this->request->getPost('name'),
            ];

            // Add password to update data if provided
            if (!empty($password)) {
                $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            // Update user in database
            $updated = $this->model->update($userId, $updateData);

            if ($updated) {
                return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui profil.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error updating profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
