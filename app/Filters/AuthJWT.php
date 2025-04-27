<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

// Tambahkan ini
helper('jwt');

class AuthJWT implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return service('response')->setJSON([
                'status' => 401,
                'message' => 'Token tidak ditemukan',
                'data' => null
            ]);
        }

        $token = $matches[1];
        $decoded = decode_jwt($token);

        if (!$decoded) {
            return service('response')->setJSON([
                'status' => 401,
                'message' => 'Token tidak valid atau kadaluarsa',
                'data' => null
            ]);
        }

        $request->user = $decoded;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do
    }
}
