<?php

namespace albertborsos\billingo\api\invoices;

use yii\base\BaseObject;

class InvoiceItem extends BaseObject
{
    public static function factoryFromProductId($id)
    {
        return ['product_uid' => $id];
    }

    public static function factory($description, $vatId, $quantity, $grossUnitPrice, $unit, $comment = null)
    {
        $data = [
            'description' => $description,
            'vat_id' => $vatId,
            'qty' => $quantity,
            'gross_unit_price' => $grossUnitPrice,
            'unit' => $unit,
            'item_comment' => $comment,
        ];

        foreach ($data as $attribute => $value) {
            if ($value === null) {
                unset($data[$attribute]);
            }
        }

        return $data;
    }
}
