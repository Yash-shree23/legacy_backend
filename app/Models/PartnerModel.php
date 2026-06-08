<?php

namespace App\Models;

use CodeIgniter\Model;

class PartnerModel extends Model
{
    protected $table = 'partners';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'logo',
        'company_name',
        'industry_type',
        'contact_person',
        'phone_number',
        'email_address'
    ];

    protected $returnType = 'array';
}