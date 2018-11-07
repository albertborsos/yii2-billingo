<?php

namespace albertborsos\billingo\api;

use albertborsos\ddd\interfaces\FormObject;
use yii\base\Model;

class AbstractApiDataForm extends Model implements FormObject
{
    /**
     * Returns attributes with not `null` values
     *
     * @return array
     */
    public function getData()
    {
        $data = [];
        foreach ($this->attributes as $attribute => $value) {
            if ($value === null || (is_array($value) && empty($value))) {
                continue;
            }
            $data[$attribute] = $value;
        }

        return $data;
    }
}
