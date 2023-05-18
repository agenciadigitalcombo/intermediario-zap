<?php

namespace model;

class Phone
{

    public $phone;
    public $ddd;
    public $valid = true;


    public function __construct(string $number)
    {
        $this->phone = $number;
        $this->clear();
        $this->ddd();
        $this->isValidDdd();
        $this->isInvalid();
        $this->phone = '55' . $this->phone;
    }

    public function clear(): void
    {
        $this->phone = preg_replace('/\D/i', '', $this->phone);
    }

    public function ddd(): void
    {
        $this->ddd = substr($this->phone, 0, 2);
    }

    public function isCellPhone(): bool
    {
        return strlen($this->phone) == 11;
    }

    public function regionsDdd(): array
    {
        return [
            '61' => 'Distrito Federal',
            '62' => 'Goiás',
            '64' => 'Goiás',
            '65' => 'Mato Grosso',
            '66' => 'Mato Grosso',
            '67' => 'Mato Grosso do Sul',
            '82' => 'Alagoas',
            '71' => 'Bahia',
            '73' => 'Bahia',
            '74' => 'Bahia',
            '75' => 'Bahia',
            '77' => 'Bahia',
            '85' => 'Ceará',
            '88' => 'Ceará',
            '98' => 'Maranhão',
            '99' => 'Maranhão',
            '83' => 'Paraíba',
            '81' => 'Pernambuco',
            '87' => 'Pernambuco',
            '86' => 'Piauí',
            '89' => 'Piauí',
            '84' => 'Rio Grande do Norte',
            '79' => 'Sergipe',
            '68' => 'Acre',
            '96' => 'Amapá',
            '92' => 'Amazonas',
            '97' => 'Amazonas',
            '91' => 'Pará',
            '93' => 'Pará',
            '94' => 'Pará',
            '69' => 'Rondônia',
            '95' => 'Roraima',
            '63' => 'Tocantins',
            '27' => 'Espírito Santo',
            '28' => 'Espírito Santo',
            '31' => 'Minas Gerais',
            '32' => 'Minas Gerais',
            '33' => 'Minas Gerais',
            '34' => 'Minas Gerais',
            '35' => 'Minas Gerais',
            '37' => 'Minas Gerais',
            '38' => 'Minas Gerais',
            '21' => 'Rio de Janeiro',
            '22' => 'Rio de Janeiro',
            '24' => 'Rio de Janeiro',
            '11' => 'São Paulo',
            '12' => 'São Paulo',
            '13' => 'São Paulo',
            '14' => 'São Paulo',
            '15' => 'São Paulo',
            '16' => 'São Paulo',
            '17' => 'São Paulo',
            '18' => 'São Paulo',
            '19' => 'São Paulo',
            '41' => 'Paraná',
            '42' => 'Paraná',
            '43' => 'Paraná',
            '44' => 'Paraná',
            '45' => 'Paraná',
            '46' => 'Paraná',
            '51' => 'Rio Grande do Sul',
            '53' => 'Rio Grande do Sul',
            '54' => 'Rio Grande do Sul',
            '55' => 'Rio Grande do Sul',
            '47' => 'Santa Catarina',
            '48' => 'Santa Catarina',
            '49' => 'Santa Catarina',
        ];
    }

    public function isValidDdd(): void
    {
        $ddd = array_keys($this->regionsDdd());
        $this->valid = in_array($this->ddd, $ddd);
    }


    public function isInvalid(): void
    {
        $tel = substr($this->phone, 2, 9);        
        $tel2 = implode('', array_reverse(str_split($tel)));
        $this->valid = $tel != $tel2;
    }

    public function getState(): string
    {
        return $this->regionsDdd()[$this->ddd] ?? 'Não identificado';
    }

}
