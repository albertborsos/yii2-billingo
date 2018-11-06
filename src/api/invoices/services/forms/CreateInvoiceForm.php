<?php

namespace albertborsos\billingo\api\invoices\services\forms;

use albertborsos\billingo\api\AbstractApiDataForm;
use albertborsos\billingo\api\invoices\InvoicesApi;

class CreateInvoiceForm extends AbstractApiDataForm
{
    public $fulfillment_date;
    public $due_date;
    public $payment_method;
    public $comment;
    public $template_lang_code;
    public $electronic_invoice;
    public $currency;
    public $exchange_rate;
    public $client_uid;
    public $block_uid = 0;
    public $type;
    public $round_to = 0;
    public $bank_account_uid;

    public $items = [];

    public function rules()
    {
        return [
            [['items'], 'required'],
            [['type'], 'in', 'range' => InvoicesApi::INVOICE_TYPES],
        ];
    }
}
