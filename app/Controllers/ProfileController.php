<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class ProfileController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return redirect()->to('/login');
        }

        return view('front/profile', ['user' => $user]);
    }

    public function update()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $validationRules = [
            'email' => 'required|valid_email|max_length[255]',
            'first_name' => 'required|max_length[50]',
            'last_name' => 'required|max_length[50]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'email' => $this->request->getPost('email'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
        ];

        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $photoName = $photo->getRandomName();
            $photo->move('uploads/profile', $photoName);
            $data['photo'] = 'uploads/profile/' . $photoName;
        }

        $userModel->update($userId, $data);

        return redirect()->to('/profile')->with('success', 'Profile updated successfully.');
    }

    public function image()
    {
        $user = $this->getCurrentUser();
        $file = $this->request->getFile('photo');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/profile', $newName);

            $userModel = new UserModel();

            if (!empty($user['photo']) && $user['photo'] !== 'assets/Profile_Photo/default.png' && file_exists($user['photo'])) {
                unlink($user['photo']);
            }

            $userModel->update($user['id'], ['photo' => 'uploads/profile/' . $newName]);
        }

        return redirect()->to('/profile')->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function apiProfile()
    {
        $decoded = service('request')->user ?? null;

        if (!$decoded) {
            return $this->failUnauthorized('Token tidak valid atau kadaluwarsa');
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $decoded->email)->first();

        if (!$user) {
            return $this->failUnauthorized('Token tidak valid atau kadaluwarsa');
        }

        return $this->respond([
            'status' => 0,
            'message' => 'Sukses',
            'data' => [
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'profile_image' => base_url($user['photo']),
            ]
        ]);
    }

    public function apiUpdate()
    {
        $decoded = service('request')->user ?? null;

        if (!$decoded) {
            return $this->failUnauthorized('Token tidak valid atau kadaluwarsa');
        }

        $data = $this->request->getJSON(true);

        $validationRules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
        ];

        if (!$this->validate($validationRules)) {
            $firstError = array_values($this->validator->getErrors())[0];
            return $this->fail($firstError, 400);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $decoded->email)->first();

        if (!$user) {
            return $this->failUnauthorized('Token tidak valid atau kadaluwarsa');
        }

        $updateData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ];

        $userModel->update($user['id'], $updateData);

        return $this->respond([
            'status' => 0,
            'message' => 'Update Profile berhasil',
            'data' => [
                'email' => $user['email'],
                'first_name' => $updateData['first_name'],
                'last_name' => $updateData['last_name'],
                'profile_image' => base_url($user['photo']),
            ]
        ]);
    }

    public function apiUploadImage()
    {
        $decoded = service('request')->user ?? null;

        if (!$decoded) {
            return $this->failUnauthorized('Token tidak valid atau kadaluwarsa');
        }

        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            return $this->fail('File tidak ditemukan atau tidak valid', 400);
        }

        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, ['image/jpeg', 'image/png'])) {
            return $this->fail('Format Image tidak sesuai', 400);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $decoded->email)->first();

        if (!$user) {
            return $this->failUnauthorized('User tidak ditemukan');
        }

        $newName = $file->getRandomName();
        $file->move('uploads/profile', $newName);

        if (!empty($user['photo']) && $user['photo'] !== 'assets/Profile_Photo/default.png' && file_exists($user['photo'])) {
            unlink($user['photo']);
        }

        $userModel->update($user['id'], ['photo' => 'uploads/profile/' . $newName]);

        return $this->respond([
            'status' => 0,
            'message' => 'Update Profile Image berhasil',
            'data' => [
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'profile_image' => base_url('uploads/profile/' . $newName),
            ]
        ]);
    }
}
