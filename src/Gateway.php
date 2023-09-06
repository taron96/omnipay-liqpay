<?php

declare(strict_types=1);

namespace Omnipay\LiqPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\LiqPay\Message\Request\CheckoutRequest;
use Omnipay\LiqPay\Message\Request\PaymentStatusRequest;

/**
 * LiqPay Gateway
 */
class Gateway extends AbstractGateway
{
    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return 'LiqPay';
    }

    /**
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [
            'public_key' => '',
            'version'    => 3,
        ];
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
    public function getVersion(): mixed
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
     * Create Purchase Request.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $options = []): AbstractRequest
    {
        return $this->createRequest(CheckoutRequest::class, $options);
    }

    /**
     * Create a retrieve order request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function fetchTransaction(array $options = []): RequestInterface|AbstractRequest
    {
        return $this->createRequest(PaymentStatusRequest::class, $options);
    }
}
