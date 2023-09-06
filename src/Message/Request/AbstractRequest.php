<?php

declare(strict_types=1);

namespace Omnipay\LiqPay\Message\Request;

use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;

use function base64_encode;
use function json_encode;
use function sha1;

/**
 * Class AbstractRequest
 *
 * @package Omnipay\LiqPay\Message
 */
abstract class AbstractRequest extends CommonAbstractRequest
{
    /**
     * Live Endpoint URL.
     *
     * @var string URL
     */
    protected string $endpoint = 'https://www.liqpay.ua/api';

    /**
     * Get endpoint for LiqPay.
     *
     * @return mixed
     */
    abstract public function getEndpoint(): string;

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->getParameter('version');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setVersion($value): static
    {
        return $this->setParameter('version', $value);
    }

    /**
     * @return mixed
     */
    public function getPublicKey(): mixed
    {
        return $this->getParameter('publicKey');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setPublicKey($value): static
    {
        return $this->setParameter('publicKey', $value);
    }

    /**
     * @return mixed
     */
    public function getPrivateKey(): mixed
    {
        return $this->getParameter('privateKey');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setPrivateKey($value): static
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * @return mixed
     */
    public function getOrderId(): mixed
    {
        return $this->getParameter('orderId');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setOrderId($value): static
    {
        return $this->setParameter('orderId', $value);
    }

    /**
     * Get url. Depends on  test mode.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->endpoint;
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in subclasses.
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * Encode data
     *
     * @param array $params
     *
     * @return string
     */
    protected function encodeParams(array $params): string
    {
        return base64_encode(json_encode($params));
    }

    /**
     * Gene
     *
     * @param string $data
     *
     * @return string
     */
    public function generateSignature(string $data): string
    {
        $privateKey = $this->getPrivateKey();

        return base64_encode(sha1($privateKey.$data.$privateKey, true));
    }
}
