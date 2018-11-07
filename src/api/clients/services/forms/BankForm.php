<?php

namespace albertborsos\billingo\api\clients\services\forms;

use albertborsos\billingo\api\AbstractApiDataForm;

class BankForm extends AbstractApiDataForm
{
    public $account_no;
    public $iban;
    public $swift;
}
