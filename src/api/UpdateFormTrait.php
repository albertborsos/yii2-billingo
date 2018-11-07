<?php

namespace albertborsos\billingo\api;

trait UpdateFormTrait
{
    public $id;

    public function rules()
    {
        return [
            [['id'], 'required'],
        ];
    }

    public function getData()
    {
        $data = parent::getData();
        unset($data['id']);

        return $data;
    }
}
