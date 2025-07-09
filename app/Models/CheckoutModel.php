<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
    protected $table = 'checkout_details';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'country', 'first_name', 'last_name', 'company_name', 'email', 'address_line1', 'address_line2',
        'city', 'state', 'zip_code', 'phone'
    ];
}
