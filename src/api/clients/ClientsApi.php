<?php

namespace albertborsos\billingo\api\clients;

use albertborsos\billingo\api\AbstractApi;

class ClientsApi extends AbstractApi
{
    protected function getRoute($id = null)
    {
        return rtrim(implode('/', [self::ROUTE_CLIENTS, $id]), '/');
    }
}
