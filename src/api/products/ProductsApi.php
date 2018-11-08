<?php

namespace albertborsos\billingo\api\products;

use albertborsos\billingo\api\AbstractApi;

class ProductsApi extends AbstractApi
{
    protected function getRoute($id = null)
    {
        return $this->renderRoute([self::ROUTE_PRODUCTS, $id]);
    }
}
