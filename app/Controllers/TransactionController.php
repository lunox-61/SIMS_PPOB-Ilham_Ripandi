<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ServiceModel;
use App\Models\TransactionModel;
use CodeIgniter\API\ResponseTrait;

class TransactionController extends BaseController
{
    use ResponseTrait;

    public function index($serviceCode)
    {
        $serviceModel = new ServiceModel();
        $service = $serviceModel->where('service_code', $serviceCode)->first();

        if (!$service) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Service tidak ditemukan.');
        }

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

        return view('front/transaction', array_merge($userData, [
            'service'      => $service,
            'service_code' => $serviceCode, 
        ]));
    }

    public function pay()
    {
        $user = $this->getCurrentUser();
        if (!$user) {
            return $this->response->setJSON(['status' => 'fail', 'message' => 'Unauthorized']);
        }

        $serviceCode = $this->request->getPost('service_code');
        $amount = (int) $this->request->getPost('amount');

        if (!$serviceCode || !$amount || $amount <= 0) {
            return $this->response->setJSON(['status' => 'fail', 'message' => 'Data transaksi tidak valid.']);
        }

        $serviceModel = new ServiceModel();
        $service = $serviceModel->where('service_code', $serviceCode)->first();

        if (!$service) {
            return $this->response->setJSON(['status' => 'fail', 'message' => 'Service tidak ditemukan.']);
        }

        if ($user['balance'] < $amount) {
            return $this->response->setJSON(['status' => 'fail', 'message' => 'Saldo tidak cukup.']);
        }

        // if ($user['balance'] > $amount) {
        //     return $this->response->setJSON(['status' => 'success', 'message' => 'Saldo cukup.']);
        // }

        $userModel = new UserModel();
        $newBalance = $user['balance'] - $amount;
        $userModel->update($user['id'], ['balance' => $newBalance]);

        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'user_id'          => $user['id'],
            'service_code'     => $service['service_code'],
            'transaction_type' => 'PAYMENT',
            'amount'           => $amount,
            'invoice_number'   => $this->generateInvoiceNumber(),
            'created_at'       => date('Y-m-d H:i:s'),
        ]);

        session()->set('user_balance', $newBalance);

        return redirect()->to('/')->with('success', 'Pembayaran berhasil.');
    }

    private function generateInvoiceNumber(): string
    {
        return 'INV' . date('YmdHis') . '-' . strtoupper(substr(uniqid(), -4));
    }

    public function history()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return redirect()->to('/login');
        }

        $transactionModel = new TransactionModel();
        $transactions = $transactionModel
            ->select('transactions.*, services.service_name')
            ->join('services', 'services.service_code = transactions.service_code', 'left') // <-- tambahkan LEFT JOIN
            ->where('transactions.user_id', $user['id'])
            ->orderBy('transactions.created_at', 'DESC')
            ->findAll();

        $userData = [
            'user_id'       => $user['id'],
            'user_email'    => $user['email'],
            'user_fullname' => $user['first_name'] . ' ' . $user['last_name'],
            'user_balance'  => $user['balance'],
            'user_photo'    => $user['photo'] ?? 'assets/Profile_Photo/default.png',
            'transactions'  => $transactions,
        ];

        return view('front/transaction_history', $userData);
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

    public function apiTransaction()
    {
        $decoded = service('request')->user ?? null;

        if (!$decoded) {
            return $this->respond([
                'status' => 108,
                'message' => 'Token tidak valid atau kadaluwarsa',
                'data' => null
            ], 401);
        }

        $serviceCode = $this->request->getJSON()->service_code ?? null;

        if (!$serviceCode) {
            return $this->respond([
                'status' => 102,
                'message' => 'Service atau Layanan tidak ditemukan',
                'data' => null
            ], 400);
        }

        $serviceModel = new \App\Models\ServiceModel();
        $service = $serviceModel->where('service_code', $serviceCode)->first();

        if (!$service) {
            return $this->respond([
                'status' => 102,
                'message' => 'Service atau Layanan tidak ditemukan',
                'data' => null
            ], 400);
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $decoded->email)->first();

        if (!$user || $user['balance'] < $service['service_tariff']) {
            return $this->respond([
                'status' => 102,
                'message' => 'Saldo tidak cukup',
                'data' => null
            ], 400);
        }

        // Update balance user
        $newBalance = $user['balance'] - $service['service_tariff'];
        $userModel->update($user['id'], ['balance' => $newBalance]);

        // Insert transaksi
        $transactionModel = new \App\Models\TransactionModel();
        $invoiceNumber = 'INV' . date('YmdHis') . '-' . strtoupper(substr(uniqid(), -4));
        $transactionModel->insert([
            'user_id'          => $user['id'],
            'service_code'     => $service['service_code'],
            'transaction_type' => 'PAYMENT',
            'amount'           => $service['service_tariff'],
            'invoice_number'   => $invoiceNumber,
            'created_at'       => date('Y-m-d H:i:s'),
        ]);

        return $this->respond([
            'status' => 0,
            'message' => 'Transaksi berhasil',
            'data' => [
                'invoice_number'   => $invoiceNumber,
                'service_code'     => $service['service_code'],
                'service_name'     => $service['service_name'],
                'transaction_type' => 'PAYMENT',
                'total_amount'     => (int) $service['service_tariff'],
                'created_on'       => date('c'),
            ]
        ], 200);
    }

    public function apiTransactionHistory()
    {
        $decoded = service('request')->user ?? null;

        if (!$decoded) {
            return $this->respond([
                'status' => 108,
                'message' => 'Token tidak valid atau kadaluwarsa',
                'data' => null
            ], 401);
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $decoded->email)->first();

        if (!$user) {
            return $this->respond([
                'status' => 108,
                'message' => 'Token tidak valid atau kadaluwarsa',
                'data' => null
            ], 401);
        }

        $transactionModel = new \App\Models\TransactionModel();

        $offset = (int) $this->request->getGet('offset') ?? 0;
        $limit  = (int) $this->request->getGet('limit') ?? 0;

        $builder = $transactionModel
            ->select('transactions.*, services.service_name')
            ->join('services', 'services.service_code = transactions.service_code', 'left')
            ->where('transactions.user_id', $user['id'])
            ->orderBy('transactions.created_at', 'DESC');

        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }

        $transactions = $builder->findAll();

        $records = [];
        foreach ($transactions as $trx) {
            $records[] = [
                'invoice_number'   => $trx['invoice_number'],
                'transaction_type' => $trx['transaction_type'],
                'description'      => $trx['transaction_type'] === 'TOPUP' ? 'Top Up balance' : ($trx['service_name'] ?? ''),
                'total_amount'     => (int) $trx['amount'],
                'created_on'       => date('c', strtotime($trx['created_at'])),
            ];
        }

        return $this->respond([
            'status' => 0,
            'message' => 'Get History Berhasil',
            'data' => [
                'offset' => $offset,
                'limit'  => $limit,
                'records' => $records
            ]
        ], 200);
    }
}
