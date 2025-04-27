<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'email',
        'first_name',
        'last_name',
        'password',
        'photo',
        'balance', 
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $useTimestamps    = true;
    protected $useSoftDeletes   = false;
}
