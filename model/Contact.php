<?php

namespace model;

class Contact
{

    private $db;

    public function __construct(\core\Banco $db)
    {
        $this->db = $db;
       
    }

    public function existContact(string $ref): bool
    {
        $this->db->table('contact');
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
        string $ref
    ): void
    {       

        $aws = new \model\Aws();
        $whats  = new \model\Whats($aws);

        if (!$this->existContact($ref)) {
            $tel = new \model\Phone($phone);
            $valid = false;
            $isNumberValid = $tel->valid;
            $valid = $isNumberValid;
            if($isNumberValid) {
                $valid = $whats->sendHello($tel->phone, $name);         
            }
            $this->db->table('contact');
            $this->db->insert([
                'ref' => $ref,
                'institution_ref' => $institution_ref,
                'name' => $name,
                'ddd' => $tel->ddd,
                'phone' => $tel->phone,
                'email' => $email,
                'status' => (int) $valid,
                'sender' => 0,
                'register_date' => date('Y-m-d'),
                'custom' => serialize([]),
            ]);

            print_r([
                'ref' => $ref,
                'institution_ref' => $institution_ref,
                'name' => $name,
                'ddd' => $tel->ddd,
                'phone' => $tel->phone,
                'email' => $email,
                'status' => (int) $valid,
                'sender' => 0,
                'register_date' => date('Y-m-d'),
                'custom' => serialize([]),
            ]);
        }
    }
}
