<?php

declare(strict_types=1);

namespace Omnipay\LiqPay\Message\Request;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\LiqPay\Message\Response\PaymentStatusResponse;

use function http_build_query;

/**
 * Class PaymentStatusRequest
 *
 * @package Omnipay\LiqPay\Message
 */
class PaymentStatusRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->getUrl().'/request';
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'public_key' => $this->getPublicKey(),
            'version'    => $this->getVersion(),
            'action'     => 'status',
            'order_id'   => $this->getOrderId(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data): ResponseInterface
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $data = $this->encodeParams($data);

        $response = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            http_build_query([
                'data'      => $data,
                'signature' => $this->generateSignature($data),
            ])
        );

        return $this->createResponse($response->getBody()->getContents());
    }

    /**
     * @param array $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    protected function createResponse(string $data): ResponseInterface
    {
        return $this->response = new PaymentStatusResponse($this, $data);
    }
}
