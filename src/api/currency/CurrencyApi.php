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
     * @return integer|array
     */
    public function convert($fromCurrency, $toCurrency, $value)
    {
        $result = $this->getApi()->get($this->getRoute(), [
            'from' => $fromCurrency,
            'to' => $toCurrency,
            'value' => $value,
        ]);

        if ($result['success']) {
            return ArrayHelper::getValue($result, 'data.value', false);
        }

        return ArrayHelper::getValue($result, 'errors', []);
    }
}
