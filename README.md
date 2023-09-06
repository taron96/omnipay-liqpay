# Omnipay: LiqPay

**LiqPay driver for the Omnipay Laravel payment processing library**

[![Latest Stable Version](https://poser.pugx.org/taron96/omnipay-liqpay/version.png)](https://packagist.org/packages/taron96/omnipay-liqpay)
[![Total Downloads](https://poser.pugx.org/taron96/omnipay-liqpay/d/total.png)](https://packagist.org/packages/taron96/omnipay-liqpay)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.5+. This package implements LiqPay support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "taron96/omnipay-liqpay": "v1.0.0"
    }
}
```

And run composer to update your dependencies:

    composer update

Or you can simply run

    composer require taron96/omnipay-liqpay

## Basic Usage

1. Use Omnipay gateway class:

```php
    use Omnipay\Omnipay;
```

2. Initialize LiqPay gateway:

```php
    $gateway = Omnipay::create('LiqPay');
    $gateway->setPublicKey(env('LIQPAY_PUBLIC_KEY'));
    $gateway->setPrivateKey(env('LIQPAY_PRIVATE_KEY'));
```

3. Call purchase, pass all necessary data and call sendData. It will return Response object which will contain all necessary data for form submission.

```php

    $request = $gateway->purchase();

    $request->setAmount(10);
    $request->setCurrency('USD');
    $request->setDescription('Product payment.');
    $request->setOrderId(XXXX);
    $request->setResultUrl(env('LIQPAY_RETURN_URL'));
    
    $response = $request->sendData($request->getData());
```

4. Create a webhook controller to handle the callback request at your `LIQPAY_RETURN_URL` and catch the webhook as follows

```php

    $gateway = Omnipay::create('LiqPay');
    $gateway->setPublicKey(env('LIQPAY_PUBLIC_KEY'));
    $gateway->setPrivateKey(env('LIQPAY_PRIVATE_KEY'));
    
    $request = $this->gateway->fetchTransaction();

    $request->setOrderId(XXXX);

    $purchase = $request->send();
    
    // Do the rest with $purchase and response with 'OK'
    if ($purchase->isSuccessful()) {
        // Your logic
    }
    
    return new Response('OK');

```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay), so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/taron96/omnipay-liqpay/issues),
or better yet, fork the library and submit a pull request.