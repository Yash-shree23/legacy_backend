<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourceController;

class AssignmentController extends ResourceController
{
    public function assign()
    {
        $db = \Config\Database::connect();

        $data = $this->request->getJSON(true);

        $member = $db->table('team_members')
            ->where('id', $data['team_member_id'])
            ->get()
            ->getRowArray();

        $memberName = $member['name'] ?? '';

        // Insert / Update Assignment Table
        $existing = $db->table('enquiry_assignments')
            ->where(
                'enquiry_unique_id',
                $data['enquiry_unique_id']
            )
            ->get()
            ->getRowArray();

        if ($existing)
        {
            $db->table('enquiry_assignments')
                ->where('id', $existing['id'])
                ->update([
                    'team_member_id' => $data['team_member_id'],
                    'status'         => 'Assigned',
                    'updated_at'     => date('Y-m-d H:i:s')
                ]);
        }
        else
        {
            $db->table('enquiry_assignments')
                ->insert([
                    'enquiry_unique_id' => $data['enquiry_unique_id'],
                    'enquiry_type'      => $data['enquiry_type'],
                    'team_member_id'    => $data['team_member_id'],
                    'status'            => 'Assigned',
                    'assigned_at'       => date('Y-m-d H:i:s')
                ]);
        }

        // Update Original Enquiry Table
        $parts = explode('_', $data['enquiry_unique_id']);

        $type = $parts[0];
        $id   = $parts[1];

        $table = '';

        if ($type === 'service')
        {
            $table = 'service_enquiries';
        }
        elseif ($type === 'contact')
        {
            $table = 'contact_enquiries';
        }
        elseif ($type === 'consult')
        {
            $table = 'consultation_requests';
        }

        if ($table != '')
        {
            $db->table($table)
                ->where('id', $id)
                ->update([
                    'status'      => 'Assigned',
                    'assigned_to' => $memberName
                ]);
        }

        return $this->respond([
            'success' => true,
            'message' => 'Assigned Successfully'
        ]);
    }

    public function updateStatus()
    {
        $db = \Config\Database::connect();

        $data = $this->request->getJSON(true);

        // Update Assignment Table
        $db->table('enquiry_assignments')
            ->where(
                'enquiry_unique_id',
                $data['enquiry_unique_id']
            )
            ->update([
                'status'     => $data['status'],
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        // Update Original Table
        $parts = explode(
            '_',
            $data['enquiry_unique_id']
        );

        $type = $parts[0];
        $id   = $parts[1];

        $table = '';

        if ($type === 'service')
        {
            $table = 'service_enquiries';
        }
        elseif ($type === 'contact')
        {
            $table = 'contact_enquiries';
        }
        elseif ($type === 'consult')
        {
            $table = 'consultation_requests';
        }

        if ($table != '')
        {
            $db->table($table)
                ->where('id', $id)
                ->update([
                    'status' => $data['status']
                ]);
        }

        return $this->respond([
            'success' => true,
            'message' => 'Status Updated'
        ]);
    }
}