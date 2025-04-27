<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan dulu tabel services
        $this->db->table('services')->truncate();

        // Data services
        $data = [
            [
                'service_code'   => 'PAJAK',
                'service_name'   => 'PBB',
                'service_icon'   => 'assets/PBB.png',
                'service_tariff' => 40000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'PLN',
                'service_name'   => 'Listrik',
                'service_icon'   => 'assets/Listrik.png',
                'service_tariff' => 10000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'PULSA',
                'service_name'   => 'Pulsa',
                'service_icon'   => 'assets/Pulsa.png',
                'service_tariff' => 40000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'PDAM',
                'service_name'   => 'PDAM',
                'service_icon'   => 'assets/PDAM.png',
                'service_tariff' => 40000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'PGN',
                'service_name'   => 'PGN',
                'service_icon'   => 'assets/PGN.png',
                'service_tariff' => 50000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'TV',
                'service_name'   => 'TV Langganan',
                'service_icon'   => 'assets/Televisi.png',
                'service_tariff' => 50000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'MUSIK',
                'service_name'   => 'Musik',
                'service_icon'   => 'assets/Musik.png',
                'service_tariff' => 50000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'VOUCHER_GAME',
                'service_name'   => 'Voucher Game',
                'service_icon'   => 'assets/Game.png',
                'service_tariff' => 100000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'VOUCHER_MAKANAN',
                'service_name'   => 'Voucher Makanan',
                'service_icon'   => 'assets/Voucher Makanan.png',
                'service_tariff' => 100000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'QURBAN',
                'service_name'   => 'Kurban',
                'service_icon'   => 'assets/Kurban.png',
                'service_tariff' => 200000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'ZAKAT',
                'service_name'   => 'Zakat',
                'service_icon'   => 'assets/Zakat.png',
                'service_tariff' => 300000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'PAKET_DATA',
                'service_name'   => 'Paket Data',
                'service_icon'   => 'assets/Paket Data.png',
                'service_tariff' => 50000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'service_code'   => 'TOPUP',
                'service_name'   => 'Top Up Saldo',
                'service_icon'   => 'assets/Topup.png', // Kamu siapkan ikon sendiri untuk Top Up, misal Topup.png
                'service_tariff' => 0, // Tariff 0 karena ini bukan pembayaran
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

        ];

        // Insert semua data ke tabel services
        $this->db->table('services')->insertBatch($data);
    }
}
