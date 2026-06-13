<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourceController;

class DashboardController extends ResourceController
{
    public function stats()
    {
        $db = \Config\Database::connect();

        $contacts = $db->table('contact_enquiries')->countAllResults();

        $consultations = $db->table('consultation_requests')->countAllResults();

        $services = $db->table('service_enquiries')->countAllResults();

        $team = $db->table('team_members')->countAllResults();
        $partners = $db->table('partners')->countAllResults();

        return $this->respond([
            'contacts' => $contacts,
            'consultations' => $consultations,
            'services' => $services,
            'team' => $team,
            'partners' => $partners,
            'total' => $contacts + $consultations + $services
        ]);
    }

    public function recentEnquiries()
{
    $db = \Config\Database::connect();

    $contacts = $db->table('contact_enquiries')
        ->select("
            CONCAT('contact_', id) as unique_id,
            id,
            full_name as name,
            phone,
            message,
            'Contact' as type,
            created_at
        ")
        ->get()
        ->getResultArray();

    $consultations = $db->table('consultation_requests')
        ->select("
            CONCAT('consult_', id) as unique_id,
            id,
            full_name as name,
            phone,
            message,
            'Consultation' as type,
            created_at
        ")
        ->get()
        ->getResultArray();

    $services = $db->table('service_enquiries')
        ->select("
            CONCAT('service_', id) as unique_id,
            id,
            full_name as name,
            phone,
            message,
            'Service' as type,
            created_at
        ")
        ->get()
        ->getResultArray();

    $all = array_merge(
        $contacts,
        $consultations,
        $services
    );

    foreach ($all as &$row)
    {
        $assignment = $db->table('enquiry_assignments ea')
            ->select('ea.status, tm.name as assigned_to')
            ->join(
                'team_members tm',
                'tm.id = ea.team_member_id',
                'left'
            )
            ->where(
                'ea.enquiry_unique_id',
                $row['unique_id']
            )
            ->get()
            ->getRowArray();

        $row['status'] =
            $assignment['status'] ?? 'Pending';

        $row['assignedTo'] =
            $assignment['assigned_to'] ?? null;
    }

    usort($all, function ($a, $b) {
        return strtotime($b['created_at'])
            - strtotime($a['created_at']);
    });

    return $this->respond(
        array_slice($all, 0, 10)
    );
}
public function allServiceEnquiries()
{
    $db = \Config\Database::connect();

    $services = $db->table('service_enquiries se')
        ->select("
            CONCAT('service_', se.id) as unique_id,
            se.id,
            se.service_name,
            se.full_name as name,
            se.phone,
            se.message,
            se.created_at,
            se.status,
            se.assigned_to
        ")
        ->orderBy('se.created_at', 'DESC')
        ->get()
        ->getResultArray();

    return $this->respond($services);
}
}