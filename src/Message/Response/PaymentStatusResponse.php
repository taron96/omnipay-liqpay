<?php

declare(strict_types=1);

namespace Omnipay\LiqPay\Message\Response;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

use function json_decode;

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
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $this->data = json_decode($data, true);
    }

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
