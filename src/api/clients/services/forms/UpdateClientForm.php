<?php

namespace albertborsos\billingo\api\clients\services\forms;

use albertborsos\billingo\api\UpdateFormTrait;

class UpdateClientForm extends CreateClientForm
{
    use UpdateFormTrait;

    public $force = false;
}
