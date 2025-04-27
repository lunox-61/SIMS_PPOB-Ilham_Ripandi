<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('is_logged_in')) {
            // Coba tambah log ini
            log_message('debug', 'AuthFilter: user tidak login, redirect ke /login');
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        log_message('debug', 'AuthFilter: user sudah login');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan setelah request untuk filter ini
    }
}
