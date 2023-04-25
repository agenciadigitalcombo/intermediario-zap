<?php

namespace core;

class Banco
{

    private $host, $db, $user, $pass;
    private $table;
    private $where;
    private $order;
    private $pdo;

    public function __construct()
    {

        $this->host = HOST;
        $this->db = BANCO;
        $this->user = USER;
        $this->pass = PASS;
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
        } catch (\Throwable $th) {
            $this->error();
        }
    }

    public function error(): void
    {
        echo json_encode([
            "next" => false,
            "message" => "Perda de comunicação com o banco",
            "payload" => []
        ]);
        die;
    }

    public function query(string $sql): array
    {
        try {
            $query = $this->pdo->query($sql);
            $result = $query->fetchAll();
            return $result;
        } catch (\Throwable $th) {
            $this->error();
        }
    }

    public function exec(string $sql): void
    {
        try {
            $this->pdo->query($sql);
        } catch (\Throwable $th) {
            $this->error();
        }
    }

    public function table(string $table): void
    {
        $this->table = $table;
    }

    public function where(array $argument = []): void
    {
        $where = [];
        foreach ($argument as $key => $value) {
            $where[] = "{$key}='{$value}'";
        }
        $this->where = implode(' AND ', $where);
    }

    public function orderByAsc(string $col): void
    {
        $this->order =  "ORDER BY {$col} ASC";
    }

    public function orderByDesc(string $col): void
    {
        $this->order =  "ORDER BY {$col} DESC";
    }

    public function select(): array
    {
        $where = "";
        $order = "";
        if (!empty($this->where)) $where = "WHERE {$this->where}";
        if (!empty($this->order)) $order = $this->order;
        $sql = "SELECT * FROM {$this->table} {$where} {$order}";
        return $this->query($sql);
    }

    public function insert(array $argument): void
    {
        $cols = implode(',', array_keys($argument));
        $values = array_values($argument);
        $values = array_map(function ($v) {
            return "'{$v}'";
        }, $values);
        $values = implode(',', $values);
        $sql =  "INSERT INTO {$this->table} ({$cols}) VALUES ({$values})";
        $this->exec($sql);
    }

    public function update(array $argument): void
    {
        $sets = [];
        foreach ($argument as $key => $value) {
            $sets[] = "{$key}='{$value}'";
        }
        $sets = implode(', ', $sets);
        $sql = "UPDATE {$this->table} SET {$sets} WHERE {$this->where}";
        $this->exec($sql);
    }

    public function delete(): void
    {
        $this->exec("DELETE FROM {$this->table} WHERE {$this->where}");
    }
}
