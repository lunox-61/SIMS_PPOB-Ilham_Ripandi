<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TransactionModel;
use CodeIgniter\API\ResponseTrait;

class TopupController extends BaseController
{
    use ResponseTrait;

    public function index(): string
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return redirect()->to('/login');
        }

        $userData = [
            'user_id'       => $user['id'],
            'user_email'    => $user['email'],
            'user_fullname' => $user['first_name'] . ' ' . $user['last_name'],
            'user_balance'  => $user['balance'],
            'user_photo'    => $user['photo'] ?? 'assets/Profile_Photo/default.png',
        ];

        return view('front/topup', $userData);
    }

    public function topup()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return $this->response->setJSON(['status' => 'fail', 'message' => 'Unauthorized']);
        }

        $amount = (int) $this->request->getPost('amount');

        if (!$amount || $amount <= 0) {
            return $this->response->setJSON(['status' => 'fail', 'message' => 'Invalid amount']);
        }

        $userModel = new UserModel();
        $transactionModel = new TransactionModel();

        // Update saldo user
        $newBalance = $user['balance'] + $amount;
        $userModel->update($user['id'], [
            'balance' => $newBalance,
        ]);

        // Insert transaksi topup
        $transactionModel->insert([
            'user_id'           => $user['id'],
            'service_code'      => 'TOPUP',
            'transaction_type'  => 'TOPUP',
            'amount'            => $amount,
            'invoice_number'    => $this->generateInvoiceNumber(),
            'created_at'        => date('Y-m-d H:i:s'),
        ]);

        session()->set('user_balance', $newBalance);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Top Up berhasil']);
    }

    private function generateInvoiceNumber(): string
    {
        return 'INV' . date('YmdHis') . '-' . strtoupper(substr(uniqid(), -4));
    }

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

    public function apiTopup()
    {
        $decoded = service('request')->user ?? null;

        if (!$decoded) {
            return $this->respond([
                'status' => 108,
                'message' => 'Token tidak valid atau kadaluwarsa',
                'data' => null
            ], 401);
        }

        $json = $this->request->getJSON();

        if (!isset($json->top_up_amount) || !is_numeric($json->top_up_amount) || $json->top_up_amount <= 0) {
            return $this->respond([
                'status' => 102,
                'message' => 'Paramter amount hanya boleh angka dan tidak boleh lebih kecil dari 0',
                'data' => null
            ], 400);
        }

        $amount = (int) $json->top_up_amount;

        $userModel = new UserModel();
        $transactionModel = new TransactionModel();

        $user = $userModel->where('email', $decoded->email)->first();

        if (!$user) {
            return $this->respond([
                'status' => 108,
                'message' => 'Token tidak valid atau kadaluwarsa',
                'data' => null
            ], 401);
        }

        // Update balance
        $newBalance = $user['balance'] + $amount;
        $userModel->update($user['id'], [
            'balance' => $newBalance
        ]);

        // Insert transaction
        $transactionModel->insert([
            'user_id'          => $user['id'],
            'service_code'     => 'TOPUP',
            'transaction_type' => 'TOPUP',
            'amount'           => $amount,
            'invoice_number'   => $this->generateInvoiceNumber(),
            'created_at'       => date('Y-m-d H:i:s'),
        ]);

        return $this->respond([
            'status' => 0,
            'message' => 'Top Up Balance berhasil',
            'data' => [
                'balance' => $newBalance
            ]
        ], 200);
    }
}
