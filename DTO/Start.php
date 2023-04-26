<?php

namespace DTO;

class start
{
    public $name;
    public $color;
    public $logo;
    public $ref;
    public $site;
    public $phone;
    public $email;

    public function __construct()
    {
        $this->name = $_REQUEST['instituicao']['nome'];
        $this->color = $_REQUEST['instituicao']['cor'];
        $this->logo = $_REQUEST['instituicao']['logo'];
        $this->ref = $_REQUEST['instituicao']['institution_fk'];
        $this->site = $_REQUEST['instituicao']['domain'];
        $this->phone = $_REQUEST['instituicao']['telefone'];
        $this->email = $_REQUEST['instituicao']['email'];
    }
}
