<?php

namespace App\Controllers;

use App\Models\BannerModel;

class BannerController extends BaseController
{
    public function index()
    {
        $bannerModel = new BannerModel();
        $banners = $bannerModel->findAll();

        $data = [];

        foreach ($banners as $banner) {
            $data[] = [
                'banner_name'  => $banner['banner_name'],
                'banner_image' => base_url($banner['banner_image']),
                'description'  => $banner['description'],
            ];
        }

        return $this->response->setJSON([
            'status'  => 0,
            'message' => 'Sukses',
            'data'    => $data
        ]);
    }
}
