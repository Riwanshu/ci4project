<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // your user table name
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'password']; // add more fields as needed
}
