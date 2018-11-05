<?php

namespace albertborsos\billingo;

use Billingo\API\Connector\HTTP\Request;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class Component extends \yii\base\Component
{
    const ROUTE_BASE = '/api/';
    const ROUTE_INVOICES = self::ROUTE_BASE . 'invoices';

    const INVOICES_MAX_PER_PAGE = 50;

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
     * @return Request
     */
    public function getApi()
    {
        return $this->api;
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

    /**
     * Workaround to filter for invoice attributes.
     *
     * Pass an array with attribute-value pairs as filtering data.
     *
     * ```php
     * $billingo->getInvoices([
     *      'invoice_no' => '2018-000001',
     * ]);
     *
     * $billingo->getInvoices([
     *      'client.name' => 'John Doe',
     * ]);
     * ```
     *
     * @param array $filters
     * @return array
     */
    public function getInvoices($filters = [])
    {
        $page = 1;
        $invoices = [];
        do {
            $response = $this->callGetInvoices($page);
            if (is_array($response)) {
                $invoices = ArrayHelper::merge($invoices, $response);
            }
            $page++;
        } while ($response !== null);

        if (empty($filters)) {
            return $invoices;
        }

        return array_filter($invoices, function ($item) use ($filters) {
            foreach ($filters as $attribute => $value) {
                if ($value == ArrayHelper::getValue($item, 'attributes.' . $attribute)) {
                    return true;
                }
            }

            return false;
        });
    }

    protected function callGetInvoices($page = 1, $maxPerPage = self::INVOICES_MAX_PER_PAGE)
    {
        return $this->getApi()->get(self::ROUTE_INVOICES, [
            'page' => $page,
            'max_per_page' => $maxPerPage,
        ]);
    }
}
