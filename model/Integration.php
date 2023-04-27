<?php

namespace model;

class Integration
{

    private $db;

    public function __construct(\core\BancoReadOnly $db)
    {
        $this->db = $db;        
    }

    public function getAdmin(string $inst): string
    {
        $this->db->table('institution_adm');
        $this->db->where([
            "instituition_fk" => $inst,
        ]);
        return $this->db->select()[0]['adm_fk'] ?? '';
    }

    public function whats(string $inst): array
    {
        $adm_fk = $this->getAdmin($inst);
        $this->db->table('integration');
        $this->db->where([
            'instituicao_fk' => $adm_fk,
            'tipo' => 'CANAL_WHATS',
        ]);
        $result = $this->db->select()[0] ?? []; 
        return [
            "channel" => $result['instituicao_fk'] ?? '',
            "session_token" => $result['key_1'] ?? '',
        ];
    }
}
