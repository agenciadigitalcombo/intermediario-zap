<?php

namespace model;

class Donation
{
    private $db;
    public function __construct()
    {
        $this->db = new \core\BancoReadOnly();
        $this->db->table('fatura');
    }

    public function getDonorByExternalId( string $external_ref ): string
    {
        $this->db->where([
            "external_fk" => $external_ref
        ]);
        $data = $this->db->select();        
        return $data[0]['doador_fk'] ?? '';
    }
}