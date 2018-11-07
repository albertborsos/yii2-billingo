<?php

namespace albertborsos\billingo\api\invoices;

use albertborsos\billingo\api\AbstractApi;

class InvoicesApi extends AbstractApi
{
    const INVOICE_TYPE_DRAFT = 0;
    const INVOICE_TYPE_PROFORMA = 1;
    const INVOICE_TYPE_NOT_USED_RESERVED = 2;
    const INVOICE_TYPE_NORMAL = 3;

    const INVOICE_TYPES = [
        self::INVOICE_TYPE_DRAFT,
        self::INVOICE_TYPE_PROFORMA,
//        self::INVOICE_TYPE_NOT_USED_RESERVED,
        self::INVOICE_TYPE_NORMAL,
    ];

    protected function getRoute($id = null)
    {
        return rtrim(implode('/', [self::ROUTE_INVOICES, $id]), '/');
    }

    public function types()
    {
        return self::INVOICE_TYPES;
    }
}
