<?php

namespace albertborsos\billingo\api\clients;

use albertborsos\billingo\api\AbstractApi;

class ClientsApi extends AbstractApi
{
    protected function getRoute($id = null)
    {
        return $this->renderRoute([self::ROUTE_CLIENTS, $id]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->getApi()->delete($this->getRoute($id));
    }
}
