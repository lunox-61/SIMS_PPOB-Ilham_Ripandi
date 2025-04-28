<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $isLoggedIn = session()->get('is_logged_in');
        $currentPath = uri_string(); // dapatkan path URL sekarang, contoh: 'login' atau 'register'

        // Kalau belum login
        if (! $isLoggedIn) {
            // Kalau dia lagi akses halaman login atau register, biarin (jangan redirect)
            if (in_array($currentPath, ['login', 'register', 'register/store'])) {
                log_message('debug', 'AuthFilter: user belum login tapi akses halaman login/register, diizinkan');
                return;
            }

            log_message('debug', 'AuthFilter: user belum login dan akses halaman lain, redirect ke /login');
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Kalau sudah login
        if ($isLoggedIn) {
            // Kalau dia coba buka login atau register, tendang ke home
            if (in_array($currentPath, ['login', 'register'])) {
                log_message('debug', 'AuthFilter: user sudah login, redirect ke /');
                return redirect()->to('/');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan setelah request untuk filter ini
    }
}
