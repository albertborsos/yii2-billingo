<?php

namespace albertborsos\billingo\api\currency;

use albertborsos\billingo\api\AbstractApi;
use yii\helpers\ArrayHelper;

class CurrencyApi extends AbstractApi
{
    protected function getRoute()
    {
        return self::ROUTE_CURRENCY;
    }

    /**
     * @param $fromCurrency
     * @param $toCurrency
     * @param $value
     * @return integer|false
     */
    public function convert($fromCurrency, $toCurrency, $value)
    {
        $result = $this->getApi()->get($this->getRoute(), [
            'from' => $fromCurrency,
            'to' => $toCurrency,
            'value' => $value,
        ]);

        return ArrayHelper::getValue($result, 'value', false);
    }
}
