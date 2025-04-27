<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class RegisterController extends BaseController
{
    use ResponseTrait;

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
            'photo'      => 'assets/Profile_Photo/default.png', 
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function apiRegister()
    {
        $data = $this->request->getJSON(true);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'email'            => 'required|valid_email|is_unique[users.email]',
            'first_name'       => 'required|min_length[2]',
            'last_name'        => 'required|min_length[2]',
            'password'         => 'required|min_length[6]'
        ]);

        if (! $validation->run($data)) {
            // Ambil satu error pertama untuk dikirimkan (biar rapi kayak dokumentasi)
            $firstError = array_values($validation->getErrors())[0];

            return $this->respond([
                'status' => 102,
                'message' => $firstError,
                'data' => null
            ], 400);
        }

        $userModel = new UserModel();
        $userModel->save([
            'email'      => $data['email'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'password'   => password_hash($data['password'], PASSWORD_DEFAULT),
            'photo'      => 'assets/Profile_Photo/default.png'
        ]);

        return $this->respond([
            'status' => 0,
            'message' => 'Registrasi berhasil silahkan login',
            'data' => null
        ], 200);
    }
}
