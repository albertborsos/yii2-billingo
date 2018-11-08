<?php

namespace albertborsos\billingo\api\bankAccounts;

use albertborsos\billingo\api\AbstractApi;

class BankAccountsApi extends AbstractApi
{
    protected function getRoute($id = null)
    {
        return $this->renderRoute([self::ROUTE_BANK_ACCOUNTS, $id]);
    }
}
