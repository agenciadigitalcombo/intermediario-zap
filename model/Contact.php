<?php

namespace model;

class Contact
{

    private $db;

    public function __construct(\core\Banco $db)
    {
        $this->db = $db;
        $this->db->table('contact');
    }

    public function existContact(string $ref): bool
    {
        $this->db->where([
            'ref' => $ref
        ]);
        return count($this->db->select()) > 0;
    }

    public function register(
        string $institution_ref,
        string $name,
        string $phone,
        string $email,
        string $external_id
    ): void
    {
        $donation = new \model\Donation();
        $ref = $donation->getDonorByExternalId($external_id);
        if (!$this->existContact($ref)) {
            $tel = new \model\Phone($phone);
            $valid = false;
            $isNumberValid = $tel->valid;
            $valid = $isNumberValid;
            if($isNumberValid) {
                
            }
            $this->db->insert([
                'ref' => $ref,
                'institution_ref' => $institution_ref,
                'name' => $name,
                'ddd' => $tel->ddd,
                'phone' => $tel->phone,
                'email' => $email,
                'status' => $valid,
                'sender' => 0,
                'register_date' => date('Y-m-d'),
                'custom' => serialize([]),
            ]);
        }
    }
}
