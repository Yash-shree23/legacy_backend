<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PartnerModel;

class PartnerController extends BaseController
{
    public function index()
    {
        $model = new PartnerModel();

        return $this->response->setJSON(
            $model->findAll()
        );
    }

    public function store()
    {
        $model = new PartnerModel();

        $logo = null;

        if ($file = $this->request->getFile('logo')) {

            if ($file->isValid() && !$file->hasMoved()) {

                $newName = $file->getRandomName();

                $file->move(
                    FCPATH . 'uploads/partners',
                    $newName
                );

                $logo = $newName;
            }
        }

        $model->insert([
            'logo'            => $logo,
            'company_name'    => $this->request->getPost('company_name'),
            'industry_type'   => $this->request->getPost('industry_type'),
            'contact_person'  => $this->request->getPost('contact_person'),
            'phone_number'    => $this->request->getPost('phone_number'),
            'email_address'   => $this->request->getPost('email_address'),
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Partner added successfully'
        ]);
    }

    public function delete($id)
    {
        $model = new PartnerModel();

        $model->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Partner deleted successfully'
        ]);
    }
}