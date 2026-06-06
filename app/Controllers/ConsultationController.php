<?php

namespace App\Controllers;

use App\Models\ConsultationModel;
use CodeIgniter\RESTful\ResourceController;

class ConsultationController extends ResourceController
{
    public function store()
    {
        $data = $this->request->getJSON(true);

        $model = new ConsultationModel();

        $model->insert([
            'full_name'      => $data['name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'],
            'service'        => $data['service'],
            'preferred_date' => null,
            'message'        => $data['message']
        ]);

        // Customer Mail

        $email = \Config\Services::email();

        $email->setFrom(
            'yashashreejahagirdar274@gmail.com',
            'Legacy Legal Services'
        );

        $email->setTo($data['email']);

        $email->setSubject('Consultation Request Received');

        $email->setMessage("
            <h2>Thank You For Booking A Consultation</h2>

            <p>Dear {$data['name']},</p>

            <p>
                We have received your consultation request.
            </p>

            <p>
                Our advisor will contact you within 24 hours.
            </p>

            <br>

            <p>
                Regards,<br>
                Legacy Legal Services
            </p>
        ");

        $email->send();

        // Admin Mail

        $adminEmail = \Config\Services::email();

        $adminEmail->setFrom(
            'yashashreejahagirdar274@gmail.com',
            'Legacy Legal Services'
        );

        $adminEmail->setTo(
            'yashashreejahagirdar274@gmail.com'
        );

        $adminEmail->setSubject(
            'New Consultation Request'
        );

        $adminEmail->setMessage("
            <h3>New Consultation Request</h3>

            <p><strong>Name:</strong> {$data['name']}</p>

            <p><strong>Email:</strong> {$data['email']}</p>

            <p><strong>Phone:</strong> {$data['phone']}</p>

            <p><strong>Service:</strong> {$data['service']}</p>

            <p><strong>Message:</strong> {$data['message']}</p>
        ");

        $adminEmail->send();

        return $this->respond([
            'status' => true,
            'message' => 'Consultation submitted successfully'
        ]);
    }
}