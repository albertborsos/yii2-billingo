<?php

namespace albertborsos\billingo\api\paymentMethods;

use albertborsos\billingo\api\AbstractApi;
use yii\helpers\ArrayHelper;

class PaymentMethodsApi extends AbstractApi
{
    public $langCode;

    protected function getRoute($id = null)
    {
        return $this->renderRoute([self::ROUTE_PAYMENT_METHODS, $this->langCode]);
    }

    public function getAll()
    {
        return parent::get();
    }

    public function getById($id)
    {
        $result = $this->getAllByAttributes(['id' => $id]);

        return array_shift($result);
    }

    public function getAllByAttributes(array $attributes)
    {
        $models = ArrayHelper::getValue(parent::get(), 'data', []);

        if (empty($attributes)) {
            return $models;
        }

        return array_filter($models, function ($item) use ($attributes) {
            foreach ($attributes as $attribute => $value) {
                if ($value == ArrayHelper::getValue($item, 'attributes.' . $attribute)) {
                    return true;
                }
            }

            return false;
        });
    }
}
