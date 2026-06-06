<?php

namespace App\Controllers;

use App\Models\ContactModel;
use CodeIgniter\RESTful\ResourceController;

class ContactController extends ResourceController
{
 public function store()
{
    $data = $this->request->getJSON(true);

    // Save in Database
    $model = new ContactModel();

    $model->insert([
        'full_name' => $data['full_name'],
        'email'     => $data['email'],
        'phone'     => $data['phone'],
        'subject'   => $data['subject'],
        'message'   => $data['message']
    ]);

    // Customer Mail
    $email = \Config\Services::email();

    $email->setFrom(
        'yashashreejahagirdar274@gmail.com',
        'Legacy Legal Services'
    );

    $email->setTo($data['email']);

    $email->setSubject('Thank You For Contacting Legacy');

    $email->setMessage("
        <h2>Thank You For Contacting Legacy</h2>

        <p>Dear {$data['full_name']},</p>

        <p>
            We have received your enquiry successfully.
        </p>

        <p>
            Our legal advisor will contact you shortly.
        </p>

        <br>

        <p>
            Regards,<br>
            Team Legacy Legal Services
        </p>
    ");

    $email->send();

    // Admin Mail
    $adminEmail = \Config\Services::email();

    $adminEmail->setFrom(
        'yashashreejahagirdar274@gmail.com',
        'Legacy Legal Services'
    );

    $adminEmail->setTo('yashashreejahagirdar274@gmail.com');

    $adminEmail->setSubject('New Contact Enquiry');

    $adminEmail->setMessage("
        <h3>New Contact Enquiry Received</h3>

        <p><strong>Name:</strong> {$data['full_name']}</p>
        <p><strong>Email:</strong> {$data['email']}</p>
        <p><strong>Phone:</strong> {$data['phone']}</p>
        <p><strong>Subject:</strong> {$data['subject']}</p>
        <p><strong>Message:</strong> {$data['message']}</p>
    ");

    $adminEmail->send();

    return $this->respond([
        'status' => true,
        'message' => 'Enquiry submitted successfully'
    ]);
}
}