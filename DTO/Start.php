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
    public $cc_name;
    public $cc_email;
    public $cc_phone;
    public $external_id;

    public function __construct()
    {
        $this->name = $_REQUEST['instituicao']['nome'];
        $this->color = $_REQUEST['instituicao']['cor'];
        $this->logo = $_REQUEST['instituicao']['logo'];
        $this->ref = $_REQUEST['instituicao']['institution_fk'];
        $this->site = $_REQUEST['instituicao']['domain'];
        $this->phone = $_REQUEST['instituicao']['telefone'];
        $this->email = $_REQUEST['instituicao']['email'];

        $this->cc_name = $_REQUEST['nome'];
        $this->cc_email = $_REQUEST['email'];
        $this->cc_phone = $_REQUEST['telefone'];
        
        $this->external_id = $_REQUEST['external_id'];
    }
}