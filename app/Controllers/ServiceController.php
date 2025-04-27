<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ServiceModel;
use CodeIgniter\API\ResponseTrait;

class ServiceController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $services = (new ServiceModel())->findAll();

        return $this->respond([
            'status'  => 0,
            'message' => 'Sukses',
            'data'    => $services
        ], 200);
    }
}
