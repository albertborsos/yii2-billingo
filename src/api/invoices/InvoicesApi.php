<?php

namespace albertborsos\billingo\api\invoices;

use albertborsos\billingo\api\AbstractApi;

class InvoicesApi extends AbstractApi
{
    protected function getRoute()
    {
        return self::ROUTE_INVOICES;
    }
}
