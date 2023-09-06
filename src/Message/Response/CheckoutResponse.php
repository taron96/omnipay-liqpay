<?php

declare(strict_types=1);

namespace Omnipay\LiqPay\Message\Response;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * LiqPay Response.
 *
 * This is the response class for all LiqPay requests.
 *
 * @see \Omnipay\LiqPay\Gateway
 */
class CheckoutResponse extends OmnipayAbstractResponse implements RedirectResponseInterface
{
    /**
     * @inheritDoc
     */
    public function isRedirect(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getRedirectMethod(): string
    {
        return 'POST';
    }

    /**
     * @inheritDoc
     */
    public function getRedirectData(): array
    {
        return $this->request->getData();
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl()
    {
        return $this->request->getEndpoint();
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return false;
    }
}
