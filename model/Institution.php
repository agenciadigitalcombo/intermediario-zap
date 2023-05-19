<?php

namespace model;

class Institution
{

    private $db;

    public function __construct(\core\Banco $banco)
    {
        $this->db = $banco;
        
    }

    public function register(
        string $name,
        string $color,
        string $logo,
        string $ref,
        string $site,
        string $phone,
        string $email
    ): void {
 
        if (!$this->isRegister($ref)) {

            $db_read_only = new \core\BancoReadOnly();
            $integration = new \model\Integration($db_read_only);
            $dados_whats = $integration->whats($ref);

            $channel = $dados_whats['channel'];
            $session_token = $dados_whats['session_token'];

            $aws = new \model\Aws();
            $whats = new \model\Whats($aws);
            $isConnected = $whats->status($channel, $session_token);

            $tel = new \model\Phone($phone);

            $this->db->table('institution');
            $this->db->insert([
                'name' => $name,
                'color' => $color,
                'logo' => $logo,
                'ref' => $ref,
                'site' => $site,
                'phone' => $tel->phone,
                'email' => $email,
                'register_date' => date('Y-m-d H:i:s'),
                'register_date' => date('Y-m-d H:i:s'),
                'balance' => 1000,
                'channel' => $channel,
                'session_token' => $session_token,
                'status' => $isConnected,
                'sender' => 0,
                'fail' => 0,
                'custom' => serialize([]),
            ]);
        }
    }

    public function isRegister(string $ref): bool
    {
        $this->db->where([
            "ref" => $ref
        ]);
        return count($this->db->select()) > 0;
    }

    public function report(): array
    {
        return array_map(['\\model\\Institution', 'porter'], $this->db->select());
    }

    static public function porter(array $payload): array
    {
        return [
            "name" => $payload['name'],
            "color" => $payload['color'],
            "logo" => $payload['logo'],
            "ref" => $payload['ref'],
            "site" => $payload['site'],
            "phone" => $payload['phone'],
            "email" => $payload['email'],
            "channel" => $payload['channel'],
            "session_token" => $payload['session_token'],
            "status" => $payload['status'],
            "sender" => $payload['sender'],
            "fail" => $payload['fail'],
            "register_date" => $payload['register_date'],
            "balance" => $payload['balance'],
            "custom" => unserialize($payload['custom']),
        ];
    }
}
