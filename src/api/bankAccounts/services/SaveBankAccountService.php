<?php

namespace albertborsos\billingo\api\bankAccounts\services;

use albertborsos\billingo\Component;
use albertborsos\ddd\models\AbstractService;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

class SaveBankAccountService extends AbstractService
{
    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function execute()
    {
        /** @var Component $billingo */
        $billingo = Instance::ensure('billingo', Component::class);
        $result = $billingo->bankAccounts()->save($this->getForm());

        if ($result['success']) {
            $this->setId(ArrayHelper::getValue($result, 'data.id'));
            return true;
        }

        $this->getForm()->addErrors(ArrayHelper::getValue($result, 'errors', []));
        return false;
    }
}
