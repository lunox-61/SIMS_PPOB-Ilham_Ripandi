<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'banner_name'   => 'Banner 1',
                'banner_image'  => 'assets/Banner 1.png',
                'description'   => 'Saldo Gratis! Buat akun PPOB gratis dan dapatkan saldo langsung jadi jutawan.',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'banner_name'   => 'Banner 2',
                'banner_image'  => 'assets/Banner 2.png',
                'description'   => 'Diskon listrik! Bayar listrik dapat diskon langsung tanpa syarat.',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'banner_name'   => 'Banner 3',
                'banner_image'  => 'assets/Banner 3.png',
                'description'   => 'Promo makan! Dapatkan voucher makan di semua merchant kesayangan kamu.',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'banner_name'   => 'Banner 4',
                'banner_image'  => 'assets/Banner 4.png',
                'description'   => 'Cashback 25%! Untuk setiap pembayaran minimal transaksi Rp 100.000.',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'banner_name'   => 'Banner 5',
                'banner_image'  => 'assets/Banner 5.png',
                'description'   => 'Buy 1 Get 2! Beli satu gratis dua untuk pembelian pulsa pertama.',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'banner_name'   => 'Banner 6',
                'banner_image'  => 'assets/Banner 6.png', // Tambahan dummy banner ke-6
                'description'   => 'Spesial Promo lainnya untuk pengguna baru!',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert semua data ke tabel banners
        $this->db->table('banners')->insertBatch($data);
    }
}
