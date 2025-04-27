<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class BalanceController extends BaseController
{
    use ResponseTrait;

    public function apiBalance()
    {
        $decoded = service('request')->user ?? null;

        if (!$decoded) {
            return $this->respond([
                'status' => 108,
                'message' => 'Token tidak valid atau kadaluwarsa',
                'data' => null
            ], 401);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $decoded->email)->first();

        if (!$user) {
            return $this->respond([
                'status' => 108,
                'message' => 'Token tidak valid atau kadaluwarsa',
                'data' => null
            ], 401);
        }

        return $this->respond([
            'status' => 0,
            'message' => 'Get Balance Berhasil',
            'data' => [
                'balance' => (int) $user['balance']
            ]
        ], 200);
    }
}
