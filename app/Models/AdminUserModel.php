<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'user_id',
        'password'
    ];

    protected $returnType = 'array';
}