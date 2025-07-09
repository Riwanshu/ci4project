<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'product_id', 'image', 'name', 'quantity', 'price'];

    protected $returnType = 'array';
    protected $useTimestamps = false;
}
