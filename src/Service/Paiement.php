<?php

namespace App\Service;

use App\Service\Cart;

class Paiement
{

    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function create()
    {
        $total = $this->cart->getTotal();


        \Stripe\Stripe::setApiKey('sk_test_51KquN7ClMtefmikmjFeVIwmW1liL3XyoZag7nbTEMBVU81Zpa4wWlPOmI3LdyxWUIBeNOnZYqCOe3ZqBlSm9YHKa00h07rje1X');

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total * 100,
            'currency' => 'eur',
        ]);
        //  dd( $paymentIntent );
        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];
        return $paymentIntent;
    }
}