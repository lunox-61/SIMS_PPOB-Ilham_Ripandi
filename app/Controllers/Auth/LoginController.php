<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

helper('jwt');

class LoginController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view("auth/login");
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('email_error', 'Email tidak terdaftar');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('password_error', 'Password salah');
        }

        session()->set([
            'user_id'        => $user['id'],
            'user_email'     => $user['email'],
            'user_name'      => $user['first_name'],
            'user_last_name' => $user['last_name'],
            'user_balance'   => $user['balance'],
            'is_logged_in'   => true,
        ]);

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout.');
    }

    public function apiLogin()
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->respond([
                'status' => 102,
                'message' => 'Email dan password wajib diisi',
                'data' => null
            ], 400);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->respond([
                'status' => 102,
                'message' => 'Parameter email tidak sesuai format',
                'data' => null
            ], 400);
        }

        if (strlen($data['password']) < 8) {
            return $this->respond([
                'status' => 102,
                'message' => 'Password minimal 8 karakter',
                'data' => null
            ], 400);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $data['email'])->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->respond([
                'status' => 103,
                'message' => 'Username atau password salah',
                'data' => null
            ], 401);
        }

        // Siapkan JWT Token menggunakan helper
        $payload = [
            'sub' => $user['id'],
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
        ];

        $token = generate_jwt($payload);

        return $this->respond([
            'status' => 0,
            'message' => 'Login Sukses',
            'data' => [
                'token' => $token
            ]
        ], 200);
    }
}
