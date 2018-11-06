<?php

namespace albertborsos\billingo;

use albertborsos\billingo\api\invoices\InvoicesApi;
use Billingo\API\Connector\HTTP\Request;
use yii\base\InvalidConfigException;

class Component extends \yii\base\Component
{
    /**
     * @var string
     */
    public $publicKey;

    /**
     * @var string
     */
    public $privateKey;

    /**
     * @var InvoicesApi
     */
    private $invoices;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->initializeApis();
    }

    /**
     * @return InvoicesApi
     */
    public function invoices()
    {
        return $this->invoices;
    }

    /**
     * @throws InvalidConfigException
     */
    private function initializeApis()
    {
        if (empty($this->publicKey)) {
            throw new InvalidConfigException('Missing billingo public key');
        }
        if (empty($this->privateKey)) {
            throw new InvalidConfigException('Missing billingo private key');
        }

        $api = new Request([
            'public_key' => $this->publicKey,
            'private_key' => $this->privateKey,
        ]);

        $this->invoices = new InvoicesApi($api);
    }
}
