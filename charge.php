<?php

require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$STRIPE_SECRET_KEY = $_ENV['STRIPE_SECRET_KEY'];

$stripe = new \Stripe\StripeClient($STRIPE_SECRET_KEY);

$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$email = $POST['email'];
$token = $POST['stripeToke'];

$customer = $stripe->customers->create([
    'email' => $email,
    'source' => $token,
]);

$charge = \Stripe\Charge::create(array(
    "amount" => 5000,
    "currency" => "usd",
    "description" => "intro yo react course",
    "customer" => $customer->id
));
