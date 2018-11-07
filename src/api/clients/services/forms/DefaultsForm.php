<?php

namespace albertborsos\billingo\api\clients\services\forms;

use albertborsos\billingo\api\AbstractApiDataForm;

class DefaultsForm extends AbstractApiDataForm
{
    public $payment_method;
    public $electronic_invoice;
    public $invoice_due_days;
    public $invoice_currency;
    public $invoice_template_lang_code;
}
