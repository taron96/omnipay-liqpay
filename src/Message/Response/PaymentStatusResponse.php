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
class PaymentStatusResponse extends OmnipayAbstractResponse implements RedirectResponseInterface
{
    public const SUCCESS = 'success';

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return $this->isOrderCompleted();
    }

    /**
     * Is order status completed.
     *
     * @return bool
     */
    public function isOrderCompleted(): bool
    {
        if (isset($this->data['status'])) {
            return self::SUCCESS === $this->data['status'];
        }

        return false;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        if (isset($this->data['err_description'])) {
            return $this->data['err_description'];
        }

        return null;
    }
}
