<?php

namespace albertborsos\billingo\api\vat;

use albertborsos\billingo\api\AbstractApi;
use yii\helpers\ArrayHelper;

class VatApi extends AbstractApi
{
    const DEFAULT_TAX_VALUE = '0.27';

    protected function getRoute($id = null)
    {
        return self::ROUTE_VAT;
    }

    public function getDefaultVatId()
    {
        $result = $this->getApi()->get($this->getRoute(), [
            'v' => self::DEFAULT_TAX_VALUE,
        ]);

        return ArrayHelper::getValue($result, 'data.0.id');
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
