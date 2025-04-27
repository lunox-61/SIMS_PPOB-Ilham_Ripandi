<?php

namespace App\Controllers;

use App\Models\BannerModel;
use App\Models\ServiceModel;

class HomeController extends BaseController
{
    public function index()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return redirect()->to('/login');
        }

        $serviceModel = new ServiceModel();
        $bannerModel  = new BannerModel();

        $userData = [
            'user_id'        => $user['id'],
            'user_email'     => $user['email'],
            'user_fullname'  => $user['first_name'] . ' ' . $user['last_name'],
            'user_balance'   => $user['balance'],
            'user_photo'     => $user['photo'] ?? 'assets/Profile_Photo/default.png',
            'services'       => $serviceModel->findAll(),
            'banners'        => $bannerModel->findAll(),
        ];

        return view('front/home', $userData);
    }
}
