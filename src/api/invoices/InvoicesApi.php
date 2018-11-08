<?php

namespace albertborsos\billingo\api\invoices;

use albertborsos\billingo\api\AbstractApi;
use yii\helpers\ArrayHelper;

class InvoicesApi extends AbstractApi
{
    const INVOICE_TYPE_DRAFT = 0;
    const INVOICE_TYPE_PROFORMA = 1;
    const INVOICE_TYPE_NOT_USED_RESERVED = 2;
    const INVOICE_TYPE_NORMAL = 3;

    const INVOICE_TYPES = [
        self::INVOICE_TYPE_DRAFT,
        self::INVOICE_TYPE_PROFORMA,
//        self::INVOICE_TYPE_NOT_USED_RESERVED,
        self::INVOICE_TYPE_NORMAL,
    ];

    /**
     * @param $id
     * @return string
     */
    public function downloadLink($id)
    {
        $response = $this->getApi()->get($this->getRoute($id) . '/code');

        if ($response['success']) {
            return 'https://www.billingo.hu/access/c:' . ArrayHelper::getValue($response, 'data.code');
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function generate($id)
    {
        $response = $this->getApi()->get($this->getRoute($id) . '/generate');

        if ($response['success']) {
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function download($id)
    {
        return $this->getApi()->get($this->getRoute($id) . '/download');
    }

    /**
     * @param $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function cancel($id)
    {
        return $this->getApi()->get($this->getRoute($id) . '/cancel');
    }

    /**
     * @param $id
     * @return bool
     */
    public function send($id)
    {
        $response = $this->getApi()->get($this->getRoute($id) . '/send');

        if ($response['success']) {
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @param $date
     * @param $amount
     * @param $paymentMethod
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function pay($id, $date, $amount, $paymentMethod)
    {
        return $this->getApi()->post($this->getRoute($id) . '/pay', [
            'date' => $date,
            'amount' => $amount,
            'payment_method' => $paymentMethod,
        ]);
    }

    /**
     * @param $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function undoPayment($id)
    {
        return $this->getApi()->delete($this->getRoute($id) . '/pay');
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function blocks()
    {
        return $this->getApi()->get($this->getRoute() . '/blocks');
    }

    protected function getRoute($id = null)
    {
        return $this->renderRoute([self::ROUTE_INVOICES, $id]);
    }

    public function types()
    {
        return self::INVOICE_TYPES;
    }
}
