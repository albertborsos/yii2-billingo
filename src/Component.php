<?php

namespace albertborsos\billingo;

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
     * @var Request
     */
    protected $api;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->initializeApi();
    }

    /**
     * @throws InvalidConfigException
     */
    private function initializeApi()
    {
        if (empty($this->publicKey)) {
            throw new InvalidConfigException('Missing billingo public key');
        }
        if (empty($this->privateKey)) {
            throw new InvalidConfigException('Missing billingo private key');
        }

        $this->setApi(new Request([
            'public_key' => $this->publicKey,
            'private_key' => $this->privateKey,
        ]));
    }

    protected function setApi(Request $request)
    {
        $this->api = $request;
    }
}
