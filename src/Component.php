<?php

namespace albertborsos\billingo;

use albertborsos\billingo\api\clients\ClientsApi;
use albertborsos\billingo\api\invoices\InvoicesApi;
use albertborsos\billingo\api\paymentMethods\PaymentMethodsApi;
use Billingo\API\Connector\HTTP\Request;
use yii\base\InvalidConfigException;

class Component extends \yii\base\Component
{
    const LANGUAGE_CODE_HU = 'hu';
    const LANGUAGE_CODE_EN = 'en';
    const LANGUAGE_CODE_DE = 'de';

    const LANGUAGE_CODES = [
        self::LANGUAGE_CODE_HU,
        self::LANGUAGE_CODE_EN,
        self::LANGUAGE_CODE_DE,
    ];

    /**
     * @var string
     */
    public $publicKey;

    /**
     * @var string
     */
    public $privateKey;

    /**
     * @var string
     */
    public $defaultLanguageCode = 'hu';

    /**
     * @var InvoicesApi
     */
    private $_invoices;

    /**
     * @var ClientsApi
     */
    private $_clients;

    /**
     * @var PaymentMethodsApi
     */
    private $_paymentMethods;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (!in_array($this->defaultLanguageCode, self::LANGUAGE_CODES)) {
            throw new InvalidConfigException('Invalid language code');
        }
        $this->initializeApis();
    }

    /**
     * @return InvoicesApi
     */
    public function invoices()
    {
        return $this->_invoices;
    }

    /**
     * @return ClientsApi
     */
    public function clients()
    {
        return $this->_clients;
    }

    /**
     * @return PaymentMethodsApi
     */
    public function paymentMethods()
    {
        return $this->_paymentMethods;
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

        $this->_invoices = new InvoicesApi($api);
        $this->_clients = new ClientsApi($api);
        $this->_paymentMethods = new PaymentMethodsApi($api, ['langCode' => $this->defaultLanguageCode]);
    }
}
