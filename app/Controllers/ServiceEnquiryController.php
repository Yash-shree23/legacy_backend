<?php

namespace App\Controllers;

use App\Models\ServiceEnquiryModel;
use CodeIgniter\RESTful\ResourceController;

class ServiceEnquiryController extends ResourceController
{
    public function store()
    {
        $data = $this->request->getJSON(true);

        $model = new ServiceEnquiryModel();

        $model->insert([
            'service_name' => $data['service_name'],
            'full_name'    => $data['full_name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'],
            'message'      => $data['message']
        ]);

        $email = \Config\Services::email();

        // Customer Email

        $email->setFrom(
            'yashashreejahagirdar274@gmail.com',
            'Legacy Legal Services'
        );

        $email->setTo($data['email']);

        $email->setSubject('Thank You For Your Enquiry');

        $email->setMessage("
            <h2>Thank You For Your Enquiry</h2>

            <p>Dear {$data['full_name']},</p>

            <p>
                We have received your enquiry for
                <b>{$data['service_name']}</b>.
            </p>

            <p>
                Our advisor will contact you shortly.
            </p>

            <br>

            <p>
                Regards,<br>
                Team Legacy
            </p>
        ");

        $email->send();

        // Admin Email

        $email->clear();

        $email->setFrom(
            'yashashreejahagirdar274@gmail.com',
            'Legacy Legal Services'
        );

        $email->setTo('yashashreejahagirdar274@gmail.com');

        $email->setSubject(
            'New Service Enquiry - ' .
            $data['service_name']
        );

        $email->setMessage("
            <h3>New Service Enquiry</h3>

            <p><b>Service:</b> {$data['service_name']}</p>
            <p><b>Name:</b> {$data['full_name']}</p>
            <p><b>Email:</b> {$data['email']}</p>
            <p><b>Phone:</b> {$data['phone']}</p>
            <p><b>Message:</b> {$data['message']}</p>
        ");

        $email->send();

        return $this->respond([
            'status' => true,
            'message' => 'Enquiry submitted successfully'
        ]);
    }
}