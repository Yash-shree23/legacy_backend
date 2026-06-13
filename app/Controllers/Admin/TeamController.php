<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TeamModel;

class TeamController extends BaseController
{
    public function index()
    {
        $model   = new TeamModel();
        $members = $model->findAll();

        // Always return an array — fixes "filter is not a function" error
        return $this->response->setJSON(
            $members ?? []
        );
    }

    public function create()
    {
        $model = new TeamModel();
        
        $data  = $this->request->getJSON(true);
 
        $model->insert([
            'name'        => $data['name']        ?? '',
            'role'        => $data['role']        ?? '',
            'phone'       => $data['phone']       ?? '',
            'email'       => $data['email']       ?? '',
            'description' => $data['description'] ?? '',
            'image'       => $data['image']       ?? '',
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Member added successfully'
        ]);
    }

    public function update($id)
    {
        $model = new TeamModel();
        $data  = $this->request->getJSON(true);

        $model->update($id, [
            'name'        => $data['name']        ?? '',
            'role'        => $data['role']        ?? '',
            'phone'       => $data['phone']       ?? '',
            'email'       => $data['email']       ?? '',
            'description' => $data['description'] ?? '',
            'image'       => $data['image']       ?? '',
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Member updated successfully'
        ]);
    }

    public function delete($id)
    {
        $model = new TeamModel();
        $model->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Member deleted successfully'
        ]);
    }

    public function show($id)
    {
        $model  = new TeamModel();
        $member = $model->find($id);

        return $this->response->setJSON($member);
    }
}