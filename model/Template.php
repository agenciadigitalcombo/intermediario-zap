<?php

namespace model;

use core\Banco;

class Template
{
    public $db;
    public $db_prod;

    public function __construct(Banco $db)
    {
        $this->db = $db;
        $this->db_prod = new \core\BancoReadOnly();
    }

    public function isExist(string $type): bool
    {
        $this->db->table('template');
        $this->db->where([
            "message_type" => $type,
        ]);
        return count($this->db->select()) > 0;
    }

    public function getProd(
        string $type,
        string $inst_key
    ): array {
        $key = explode(':', $type);
        $this->db_prod->table('template_' . strtolower($key[0]));
        $this->db_prod->where([
            "instituicao_fk" => $inst_key,
            "tipo" => $key[1],
            "status_pagamento" => $key[2],
        ]);
        $data = $this->db_prod->select()[0] ?? [];
        return [
            "label" => $data['name'] ?? null,
            "subject" => $data['assunto'] ?? null,
            "body" => $data['content'] ?? null,
        ];
    }

    public function register(
        string $type,
        string $inst_key
    ): void {
        if (!$this->isExist($type)) {
            $dados = $this->getProd($type, $inst_key);
            $this->db->table('template');
            $this->db->insert([
                "institution_ref" => $inst_key,
                "register_date" => date('Y-m-d'),
                "update_date" => date('Y-m-d'),
                "message_type" => $type,
                "message_template" => $dados['body'],
                "custom" => serialize([
                    "label" => $dados['label'],
                    "subject" => $dados['subject'],
                ]),
            ]);
        }
    }

    public function getTemplate(
        string $type,
        string $inst_key
    ): array {
        $this->db->table('template');
        $this->db->where([
            "institution_ref" => $inst_key,
            "message_type" => $type,
        ]);
        return self::porter($this->db->select()[0] ?? []);
    }

    static function porter(array $payload): array
    {
        return [
            "id" => $payload['id'] ?? null,
            "institution_ref" => $payload['institution_ref'] ?? null,
            "register_date" => $payload['register_date'] ?? null,
            "update_date" => $payload['update_date'] ?? null,
            "message_type" => $payload['message_type'] ?? null,
            "message_template" => $payload['message_template'] ?? null,
            "custom" => unserialize($payload['custom']) ?? null,
        ];
    }

    static function allTag(): array
    {
        return [
            "{NOME}",
            "{nome_doador}",
            "{nome_doador_completo}",
            "{nome_instituicao}",
            "{link_boleto}",
            "{botao_com_boleto}",
            "{link_recuperar_doacao}",
            "{botao_recuperar_doacao}",
            "{codigo_barras_boleto}",
            "{link_recuperacao_senha}",
            "{botao_recuperacao_senha}",
            "{telefone_doador}",
            "{telefone_instituicao}",
            "{instituicao_logo}",
            "",
            "",
            "",
            "",
        ];
    }

    public function blade(
        string $body,
        array $data,
        string $template = ''
    ): string {
        if (!empty($template)) {
            $html = str_replace('@@body@@', $body, $template);
        } else {
            $html = $body;
        }
        foreach ($data as $k => $v) {
            $tag = "{" . $k . "}";
            if (!is_array($v)) {
                $html = str_replace($tag, $v, $html);
            }
        }
        $html = trim(str_replace("%20", ' ', $html));
        $style = 'style="background:#20e277;text-decoration:none !important; font-weight:700;  color:#fff;text-transform:uppercase; font-size:19px;padding:20px 30px;display:block;border-radius:50px; margin: 0 auto; width: 200px; margin-top:35px;"';
        $html = str_replace('{STYLE_BTN}', $style, $html);
        $html = str_replace('{my_content}', '', $html);
        return $html;
    }
}
