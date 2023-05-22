<?php

namespace model;

use core\Banco;

class Template
{
    public $db;
    public function __construct(Banco $db)
    {
        $this->db = $db;
    }

    public function register(
        string $type,
        string $inst_key
    ): void {
    }

    public function getTemplate(
        string $type,
        string $inst_key
    ): array {
        return [];
    }

    public function blade(
        string $body,
        array $data
    ): string {
        return '';
    }
}
