<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table      = 'services';
    protected $primaryKey = 'id';
    protected $allowedFields = ['service_code', 'service_name', 'service_icon', 'service_tariff', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
