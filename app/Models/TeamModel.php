<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table = 'team_members';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'role',
        'phone',
        'email',
        'description',
        'image'
    ];

    protected $returnType = 'array';
}