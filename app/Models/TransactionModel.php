<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions'; 
    protected $primaryKey       = 'id';            

    protected $allowedFields    = [
        'user_id',
        'invoice_number',
        'service_code',
        'service_name',
        'transaction_type',
        'amount',
        'created_at',
    ];

    protected $useTimestamps    = false; 
    protected $useSoftDeletes   = false;
}
