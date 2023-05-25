<?php

namespace model;

use core\Banco;

class Sender
{
    public $db;

    public function __construct( Banco $db )
    {
        $this->db = $db;
    }

    public function save(
        string $inst_key,
        string $contact_key,
        string $type_message,
        string $external_id,
        string $body,
        string $price,
        string $due_date       
    ):void {
        $this->db->table('sender');
        $this->db->insert([
            "ref" => $external_id,
            "institution_ref" => $inst_key,
            "contact_ref" => $contact_key,
            "register_date" => date('Y-m-d'),
            "update_date" => date('Y-m-d'),
            "message_type" => $type_message,
            "next_date" => $due_date,
            "message" => $body,
            "price" => $price,
            "status" => 200,
            "custom" => serialize([]),            
        ]);

    }
}
