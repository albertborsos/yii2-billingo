<?php

namespace albertborsos\billingo\api\clients\services\forms;

class UpdateClientForm extends CreateClientForm
{
    public $force = false;

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
