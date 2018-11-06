<?php

namespace albertborsos\billingo\api;

use Billingo\API\Connector\Contracts\Request;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

abstract class AbstractApi extends BaseObject
{
    const ROUTE_BASE = '/api/';
    const ROUTE_INVOICES = self::ROUTE_BASE . 'invoices';
    const ROUTE_CLIENTS  = self::ROUTE_BASE . 'clients';

    const MAX_PER_PAGE = 50;
    const DEFAULT_PAGE = 1;

    /**
     * @var Request
     */
    protected $api;

    /**
     * AbstractEndpoint constructor.
     * @param Request $api
     * @param array $config
     */
    public function __construct(Request $api, array $config = [])
    {
        parent::__construct($config);
        $this->setApi($api);
    }

    /**
     * @return Request
     */
    protected function getApi()
    {
        return $this->api;
    }

    /**
     * @param int $page
     * @param int $maxPerPage
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function get($page = self::DEFAULT_PAGE, $maxPerPage = self::MAX_PER_PAGE)
    {
        return $this->getApi()->get($this->getRoute(), [
            'page' => $page,
            'max_per_page' => $maxPerPage,
        ]);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return static::getAllByAttributes([]);
    }

    /**
     * @param $attributes array
     * @return mixed
     */
    public function getAllByAttributes(array $attributes)
    {
        $page = self::DEFAULT_PAGE;
        $models = [];
        do {
            $response = $this->get($page);
            if (is_array($response)) {
                $models = ArrayHelper::merge($models, $response);
            }
            $page++;
        } while ($response !== null);

        if (empty($attributes)) {
            return $models;
        }

        return array_filter($models, function ($item) use ($attributes) {
            foreach ($attributes as $attribute => $value) {
                if ($value == ArrayHelper::getValue($item, 'attributes.' . $attribute)) {
                    return true;
                }
            }

            return false;
        });
    }

    public function getById($id)
    {
        $result = $this->getApi()->get($this->getRoute() . '/' . $id);

        return array_shift($result);
    }

    abstract protected function getRoute();

    /**
     * @param Request $request
     */
    protected function setApi(Request $request)
    {
        $this->api = $request;
    }
}
