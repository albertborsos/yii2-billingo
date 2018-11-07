<?php

namespace albertborsos\billingo\api\bankAccounts\services\forms;

use albertborsos\billingo\api\AbstractApiDataForm;

class CreateBankAccountForm extends AbstractApiDataForm
{
    public $bank_name;
    public $account_no;
    public $account_no_iban;
    public $account_swift;
    public $currency;
}
