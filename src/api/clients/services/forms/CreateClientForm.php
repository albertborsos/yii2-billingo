<?php

namespace albertborsos\billingo\api\clients\services\forms;

use albertborsos\billingo\api\AbstractApiDataForm;

class CreateClientForm extends AbstractApiDataForm
{
    /**
     * Force create client if if it exists with the same name and taxcode (if given)
     *
     * @var bool
     */
    public $force = true;

    public $name;
    public $email;
    public $taxcode;
    public $phone;
    public $fokonyv_szam;
    public $type;
    public $billing_address;
    public $bank;
    public $defaults;

    protected $billing_address_form;
    protected $bank_form;
    protected $defaults_form;

    public function __construct(BillingAddressForm $billingAddressForm, BankForm $bank, DefaultsForm $defaults, array $config = [])
    {
        parent::__construct($config);
        $this->billing_address_form = $billingAddressForm;
        $this->bank_form = $bank;
        $this->defaults_form = $defaults;
    }

    public function getData()
    {
        $this->billing_address = $this->billing_address_form->getData();
        $this->bank = $this->bank_form->getData();
        $this->defaults = $this->defaults_form->getData();
        return parent::getData();
    }
}
