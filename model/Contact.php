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
        return count($this->db->select()) > 1;
    }

    public function register(
        string $ref,
        string $institution_ref,
        string $name,
        string $ddd,
        string $phone
    ): void
    {
        if (!$this->existContact($ref)) {
            $this->db->insert([
                'ref' => $ref,
                'institution_ref' => $institution_ref,
                'name' => $name,
                'ddd' => $ddd,
                'phone' => $phone,
                'status' => null,
                'sender' => 0,
                'register_date' => date('Y-m-d'),
                'custom' => serialize([]),
            ]);
        }
    }
}
