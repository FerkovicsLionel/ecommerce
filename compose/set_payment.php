<?php

error_reporting(-1);
ini_set('display_errors', 1);

if (isset($_GET['sum'])) {
    $sum=(int)$_GET['sum'];
}
else $sum=100000;


require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51IGJIQH8aiJE4qXvryFxVy8oCtJE4rRNB0Q3qPMw9L8P4NzQQZJwLu9jswHn7uyZZQj7uzu3mAIjK53gkCQ78Idg00HL0AxHb4');
header('Content-Type: application/json');

$key=md5($_GET['orderid']);

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'huf',
            'unit_amount' => $sum,
            'product_data' => [
                'name' => 'Bélyegző készítés',
            ],
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost/ecommerce/ordersuccess.php?key='.$key.'&orderfail=0&id='.$_GET['orderid'],
    'cancel_url' => 'https://localhost/ecommerce/ordersuccess.php?key='.$key.'&orderfail=1&id='.$_GET['orderid'],
]);

echo json_encode(['id' => $checkout_session->id]);