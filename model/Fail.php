<?php

namespace model;

use core\Banco;

class Fail
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
        $this->db->table('fail');
        $this->db->insert([
            "ref" => $external_id,
            "institution_ref" => $inst_key,
            "contact_ref" => $contact_key,
            "register_date" => date('Y-m-d'),
            "update_date" => date('Y-m-d'),
            "next_date" => $due_date,
            "message_type" => $type_message,
            "message" => $body,
            "price" => $price,
            "status" => 403,
            "custom" => serialize([]),
        ]);
        $this->db->exec("UPDATE institution SET fail=fail+1 WHERE ref='{$inst_key}'" );

    }
}
