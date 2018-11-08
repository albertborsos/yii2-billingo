<?php

namespace albertborsos\billingo;

use albertborsos\billingo\api\bankAccounts\BankAccountsApi;
use albertborsos\billingo\api\BillingoClient;
use albertborsos\billingo\api\clients\ClientsApi;
use albertborsos\billingo\api\currency\CurrencyApi;
use albertborsos\billingo\api\invoices\InvoicesApi;
use albertborsos\billingo\api\paymentMethods\PaymentMethodsApi;
use albertborsos\billingo\api\products\ProductsApi;
use albertborsos\billingo\api\vat\VatApi;
use Billingo\API\Connector\Contracts\Request;
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
     * @var Request
     */
    private $_api;

    /**
     * @var InvoicesApi
     */
    private $_invoices;

    /**
     * @var ClientsApi
     */
    private $_clients;

    /**
     * @var ProductsApi
     */
    private $_products;

    /**
     * @var PaymentMethodsApi
     */
    private $_paymentMethods;

    /**
     * @var BankAccountsApi
     */
    private $_bankAccounts;

    /**
     * @var CurrencyApi
     */
    private $_currency;

    /**
     * @var VatApi
     */
    private $_vat;

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
     * @return ProductsApi
     */
    public function products()
    {
        return $this->_products;
    }

    /**
     * @return PaymentMethodsApi
     */
    public function paymentMethods()
    {
        return $this->_paymentMethods;
    }

    /**
     * @return BankAccountsApi
     */
    public function bankAccounts()
    {
        return $this->_bankAccounts;
    }

    /**
     * @return CurrencyApi
     */
    public function currency()
    {
        return $this->_currency;
    }

    /**
     * @return VatApi
     */
    public function vat()
    {
        return $this->_vat;
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

        $api = new BillingoClient([
            'public_key' => $this->publicKey,
            'private_key' => $this->privateKey,
        ]);

        $this->setApi($api);
        $this->_invoices = new InvoicesApi($this->getApi());
        $this->_clients = new ClientsApi($api);
        $this->_products = new ProductsApi($api);
        $this->_paymentMethods = new PaymentMethodsApi($this->getApi(), ['langCode' => $this->defaultLanguageCode]);
        $this->_bankAccounts = new BankAccountsApi($this->getApi());
        $this->_currency = new CurrencyApi($this->getApi());
        $this->_vat = new VatApi($this->getApi());
    }

    /**
     * @param Request $api
     */
    private function setApi(Request $api)
    {
        $this->_api = $api;
    }

    /**
     * @return Request
     */
    public function getApi()
    {
        return $this->_api;
    }
}
