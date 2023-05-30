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
    public $cc_ref;
    public $status_payment;
    public $type_payment;
    public $url;
    public $code;
    public $valor;
    public $due_date;
    public $NOME;
    public $pay_id;
    public $mailSender;
    public $LINK;

    public function __construct()
    {
        $this->name = $_REQUEST['instituicao']['nome'];
        $this->color = $_REQUEST['instituicao']['cor'];
        $this->logo = $_REQUEST['instituicao']['logo'];
        $this->ref = $_REQUEST['instituicao']['institution_fk'];
        $this->site = $_REQUEST['instituicao']['domain'];
        $this->phone = $_REQUEST['instituicao']['telefone'];
        $this->email = $_REQUEST['instituicao']['email'];
        $this->mailSender = $_REQUEST['instituicao']['mailSender'];

        $this->status_payment = $_REQUEST['status_payment'];
        $this->type_payment = $_REQUEST['type_payment'];
        $this->url = $_REQUEST['url'];
        $this->LINK = $_REQUEST['url'];
        $this->code = $_REQUEST['code'];
        $this->code = $_REQUEST['code'];
        $this->pay_id = $_REQUEST['fatura_id'];

        $this->external_id = $_REQUEST['external_id'];
        $this->due_date = $_REQUEST['data'];
        $this->valor = $_REQUEST['valor'];

        $donation = new \model\Donation();       

        $this->cc_name = $_REQUEST['nome'];
        $this->NOME = $_REQUEST['nome'];
        $this->cc_email = $_REQUEST['email'];
        $this->cc_phone = $_REQUEST['telefone'];
        $this->cc_ref = $donation->getDonorByExternalId($this->external_id);

    }
}
