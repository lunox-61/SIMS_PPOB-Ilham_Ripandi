<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class RegisterController extends BaseController
{
    public function index()
    {
        return view('auth/registration');
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'email'            => 'required|valid_email|is_unique[users.email]',
            'first_name'       => 'required|min_length[2]',
            'last_name'        => 'required|min_length[2]',
            'password'         => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ]);

        if (! $validation->run($data)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Simpan user baru ke database
        $userModel = new UserModel();
        $userModel->save([
            'email'      => $data['email'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'password'   => password_hash($data['password'], PASSWORD_DEFAULT),
            'photo'      => 'assets/Profile_Photo.png', // default foto profil
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
