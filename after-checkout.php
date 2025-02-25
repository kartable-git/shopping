<?php
//session_start();
require_once 'secrets.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci</title>
</head>
<?php
require 'vendor/autoload.php';
$stripe = new \Stripe\StripeClient($stripeSecretKey);

try {
  $session = $stripe->checkout->sessions->retrieve(($_GET['session_id']),['expand' => ['customer_details']]);
  $details = $session->customer_details;
  echo "<h1>Merci pour votre commande $details->name !</h1>";
//  $session = $stripe->checkout->sessions->retrieve(($_GET['session_id']),['expand' => ['payment_intent']]);
//  $payint = $session->payment_intent;
//  echo $payint->id; //ID de paiement
  http_response_code(200);
} 
catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}