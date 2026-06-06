<?php

namespace App\Controllers\Admin;

use App\Models\AdminUserModel;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        $json = $this->request->getJSON();

        if (!$json || !isset($json->user_id) || !isset($json->password)) {
            return $this->respond([
                'status'  => false,
                'message' => 'User ID and password are required'
            ], 400);
        }

        $model = new AdminUserModel();
        $user  = $model->where('user_id', $json->user_id)->first();

        if (!$user || $json->password !== $user['password']) {
    return $this->respond([
        'status'  => false,
        'message' => 'Invalid User ID or password'
    ], 401);
}

        return $this->respond([
    'status'  => true,
    'message' => 'Login successful',
    'user'    => [
        'user_id' => $user['user_id']
    ]
], 200);
    }
}