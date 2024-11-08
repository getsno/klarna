<?php

namespace Gets\Klarna\Api;

use Gets\Klarna\Exceptions\KlarnaException;
use Gets\Klarna\Exceptions\KlarnaInvalidConfig;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Klarna
{
    /**
     * @var Client
     */
    protected $client;
    public $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = new Client(['base_uri' => $this->config->baseUrl]);
    }

    /**
     * @param string $url
     *
     * @return array
     * @throws KlarnaException
     */
    protected function getRequest(string $url): array
    {
        try {
            $options = [
                'auth'    => [$this->config->user, $this->config->password],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ];
            $response = $this->client->request('GET', $url, $options);
        } catch (GuzzleException $e) {
            $contents = ($e->getResponse())->getBody()->getContents();
            throw KlarnaException::fromResponse($contents, $e);
        }

        return ['response' => $response, 'body' => json_decode($response->getBody()->getContents())];
    }

    /**
     * @param string $url
     * @param array $body
     *
     * @return array
     * @throws KlarnaException
     * @throws KlarnaInvalidConfig
     */
    protected function postRequest(string $url, array $body): array
    {
        try {
            $options = [
                'auth'    => [$this->config->user, $this->config->password],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ],
                'json'    => $body,
            ];
            $response = $this->client->request('POST', $url, $options);
        } catch (GuzzleException $e) {
            $contents = ($e->getResponse())->getBody()->getContents();
            throw  KlarnaException::fromResponse($contents, $e);
        }

        return ['response' => $response, 'body' => json_decode($response->getBody()->getContents())];
    }

    /**
     * @param string $url
     * @param array $body
     *
     * @return array
     * @throws KlarnaException
     */
    protected function patchRequest(string $url, array $body): array
    {
        try {
            $options = [
                'auth'    => [$this->config->user, $this->config->password],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ],
                'json'    => $body,
            ];
            $response = $this->client->request('PATCH', $url, $options);
        } catch (GuzzleException $e) {
            $contents = ($e->getResponse())->getBody()->getContents();
            throw KlarnaException::fromResponse($contents, $e);
        }

        return ['response' => $response, 'body' => json_decode($response->getBody()->getContents())];
    }

    /**
     * @see https://docs.klarna.com/api/#checkout-api-create-a-new-order Docs
     * @throws KlarnaException
     * @throws KlarnaInvalidConfig
     */
    public function createOrder(array $body): array
    {
        return $this->postRequest("/checkout/v3/orders", $body);
    }

    /**
     * @see https://docs.klarna.com/api/#checkout-api-update-an-order Docs
     * @throws KlarnaException
     * @throws KlarnaInvalidConfig
     */
    public function updateOrder(string $order, array $body): array
    {
        return $this->postRequest("/checkout/v3/orders/$order", $body);
    }

    /**
     * @see https://docs.klarna.com/api/#checkout-api-update-an-order Docs
     *
     * @param string $order
     *
     * @return array
     * @throws KlarnaException
     */
    public function retrieveOrder(string $order): array
    {
        return $this->getRequest("/checkout/v3/orders/$order");
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-get-order
     *
     * @param string $order
     *
     * @return array
     * @throws KlarnaException
     */
    public function getOrder(string $order): array
    {
        return $this->getRequest("/ordermanagement/v1/orders/$order");
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-update-merchant-references Docs
     *
     * @param string $order
     * @param array $body
     *
     * @return array
     * @throws KlarnaException
     */
    public function updateOrderReferences(string $order, array $body): array
    {
        return $this->patchRequest("/ordermanagement/v1/orders/$order/merchant-references", $body);
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-cancel-order Docs
     *
     * @param string $order
     *
     * @return array
     * @throws KlarnaException
     * @throws KlarnaInvalidConfig
     */
    public function cancelOrder(string $order): array
    {
        return $this->postRequest("/ordermanagement/v1/orders/$order/cancel", []);
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-cancel-order Docs
     *
     * @param string $order
     *
     * @return array
     * @throws KlarnaException
     */
    public function getOrderCaptures(string $order): array
    {
        return $this->getRequest("/ordermanagement/v1/orders/$order/captures");
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-cancel-order Docs
     *
     * @param string $order
     * @param string $capture
     * @param array $body
     *
     * @return array
     * @throws KlarnaException
     * @throws KlarnaInvalidConfig
     */
    public function addShippingInfoToCapture(string $order, string $capture, array $body): array
    {
        return $this->postRequest("/ordermanagement/v1/orders/$order/captures/$capture/shipping-info", $body);
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-create-capture Docs
     *
     * @param string $order
     * @param array $body
     *
     * @return array
     * @throws KlarnaException
     * @throws KlarnaInvalidConfig
     */
    public function createCapture(string $order, array $body): array
    {
        return $this->postRequest("/ordermanagement/v1/orders/$order/captures", $body);
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-create-capture Docs
     *
     * @param string $order
     * @param string $capture
     *
     * @return array
     * @throws KlarnaException
     */
    public function getCapture(string $order, string $capture): array
    {
        return $this->getRequest("/ordermanagement/v1/orders/$order/captures/$capture");
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-create-a-refund Docs
     *
     * @param string $order
     * @param array $body
     *
     * @return array
     * @throws KlarnaException
     * @throws KlarnaInvalidConfig
     */
    public function createRefund(string $order, array $body): array
    {
        return $this->postRequest("/ordermanagement/v1/orders/$order/refunds", $body);
    }

    /**
     * @param string $order
     * @param string $refund
     *
     * @return array
     * @throws KlarnaException
     */
    public function getRefund(string $order, string $refund): array
    {
        return $this->getRequest("/ordermanagement/v1/orders/$order/refunds/$refund");
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-set-new-order-amount-and-order-lines
     *
     * @param string $order
     * @param array $body
     *
     * @return array
     * @throws KlarnaException
     */
    public function setNewOrderAmountAndOrderLines(string $order, array $body): array
    {
        return $this->patchRequest("/ordermanagement/v1/orders/$order/authorization", $body);
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-acknowledge-order
     *
     * @param string $order
     *
     * @return array
     * @throws KlarnaException
     * @throws KlarnaInvalidConfig
     */
    public function acknowledge(string $order): array
    {
        return $this->postRequest("/ordermanagement/v1/orders/$order/acknowledge", []);
    }

    /**
     * @see https://docs.klarna.com/api/#order-management-api-update-customer-addresses
     *
     * @param string $order
     * @param array $body
     *
     * @return array
     * @throws KlarnaException
     */
    public function updateCustomerAddress(string $order, array $body): array
    {
        return $this->patchRequest("/ordermanagement/v1/orders/$order/customer-details", $body);
    }

    /**
     * @see https://docs.klarna.com/api/ordermanagement/#operation/releaseRemainingAuthorization
     * 
     * @param string $order
     * 
     * @return array
     * @throws KlarnaException
     */
    public function releaseRemainingAuthorization(string $order): array
    {
        return $this->postRequest("/ordermanagement/v1/orders/$order/release-remaining-authorization", []);
    }
}