<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table = 'banners';
    protected $primaryKey = 'id';
    protected $allowedFields = ['banner_name', 'banner_image', 'description', 'created_at', 'updated_at'];
}
