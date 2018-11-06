<?php

namespace albertborsos\billingo\api\clients;

use albertborsos\billingo\api\AbstractApi;

class ClientsApi extends AbstractApi
{
    protected function getRoute()
    {
        return self::ROUTE_CLIENTS;
    }
}
