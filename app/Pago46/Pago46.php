<?php

namespace App\Pago46;

use App\Pago46\Caller;

class Pago46
{
    /**
     * Merchant data [key, secret]
     *
     * @var array
     */
    private $merchant = [];

    /**
     * Request data [method, path]
     *
     * @var array
     */
    private $request = [];

    /**
     * Environment
     *
     * @var string
     */
    private $env = 'production';

    /**
     * Header
     *
     * @var array
     */
    private $header = [];

    /**
     * Create a new Skeleton Instance
     */
    public function __construct($env)
    {
        $this->env = $env;
        Caller::setEnv($this->env);
        $this->merchant = [
            'key'       =>  getenv('PAGO46_MERCHANT_KEY'),
            'secret'    =>  getenv('PAGO46_MERCHANT_SECRET')
        ];
    }

    /**
     * Get transactions
     *
     * @return array
     */
    public function getOrders()
    {
        $this->request = ['method' => 'GET', 'path' => '%2Fmerchant%2Forders%2F'];
        $this->header = Caller::setHeader($this->merchant, $this->request, false);
        $api = Caller::call('merchant/orders/', $this->request['method'], false);

        return $api;
    }

    /**
     * Get order by orderId
     *
     * @param $id
     *
     * @return array
     */
    public function getOrderByID($id)
    {
        $this->request = ['method' => 'GET', 'path' => "%2Fmerchant%2Forder%2F{$id}"];
        $this->header = Caller::setHeader($this->merchant, $this->request, false);
        $api = Caller::call("merchant/order/{$id}", $this->request['method'], false);

        return $api;
    }

    /**
     * Get order by notificationId
     *
     * @param $id
     *
     * @return array
     */
    public function getOrderByNotificationID($id)
    {
        $this->request = ['method' => 'GET', 'path' => "%2Fmerchant%2Fnotification%2F{$id}"];
        $this->header = Caller::setHeader($this->merchant, $this->request, '');
        $api = Caller::call("merchant/notification/{$id}", $this->request['method'], '');

        return $api;
    }

    /**
     * Create a new order
     *
     * @param array $order
     *
     * @return array
     */
    public function newOrder($order)
    {
        $this->request = ['method' => 'POST', 'path' => '%2Fmerchant%2Forders%2F'];

        $concatenateParams = '';

        foreach ($order as $k => $v) {
            $value = urlencode($v);
            $concatenateParams .= "&{$k}={$value}";
        }

        $this->header = Caller::setHeader($this->merchant, $this->request, $concatenateParams);
        
        $api = Caller::call("merchant/orders/", $this->request['method'], $order);

        return $api;
    }
}