<?php

declare(strict_types=1);

namespace Omnipay\LiqPay\Message\Request;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\LiqPay\Message\Response\CheckoutResponse;

/**
 * Class CheckoutRequest
 *
 * @package Omnipay\LiqPay\Message
 */
class CheckoutRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getAction(): string
    {
        return 'pay';
    }

    /**
     * @return mixed
     */
    public function getResultUrl(): mixed
    {
        return $this->getParameter('resultUrl');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\LiqPay\Message\Request\CheckoutRequest
     */
    public function setResultUrl($value): static
    {
        return $this->setParameter('resultUrl', $value);
    }

    /**
     * Prepare data to send
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData(): array
    {
        $data = $this->encodeParams([
            'version'     => $this->getVersion(),
            'public_key'  => $this->getPublicKey(),
            'action'      => $this->getAction(),
            'amount'      => $this->getAmount(),
            'currency'    => $this->getCurrency(),
            'description' => $this->getDescription(),
            'order_id'    => $this->getOrderId(),
            'server_url'  => $this->getResultUrl(),
            'result_url'  => $this->getResultUrl(),
        ]);

        return [
            'data'      => $data,
            'signature' => $this->generateSignature($data),
        ];
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->getUrl().'/'.$this->getVersion().'/checkout';
    }

    /**
     * @inheritDoc
     */
    public function sendData($data): ResponseInterface
    {
        return $this->createResponse($data);
    }

    /**
     * @param array $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    protected function createResponse(array $data): ResponseInterface
    {
        return $this->response = new CheckoutResponse($this, $data);
    }
}
