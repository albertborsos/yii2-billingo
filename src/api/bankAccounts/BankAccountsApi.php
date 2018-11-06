<?php

namespace albertborsos\billingo\api\bankAccounts;

use albertborsos\billingo\api\AbstractApi;

class BankAccountsApi extends AbstractApi
{
    protected function getRoute()
    {
        return self::ROUTE_BANK_ACCOUNTS;
    }
}
