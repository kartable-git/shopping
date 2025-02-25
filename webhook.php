<?php
include('db.php');
require_once 'secrets.php';

// connection à stripe

require_once 'vendor/autoload.php';
\Stripe\Stripe::setApiKey($stripeSecretKey);
\Stripe\Stripe::setApiVersion('2025-01-27.acacia');

$endpoint_secret = "whsec_c57cdd382186924c43c009fb96bd5520ba3c9da05ae1f444818ed14db396e205";

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
  http_response_code(400);
  echo json_encode(['Error parsing payload: ' => $e->getMessage()]);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    echo json_encode(['Error verifying webhook signature: ' => $e->getMessage()]);
    exit();
}
  
// Handle the event
switch ($event->type) {
    case 'payment_intent.succeeded':
      $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
      $intent = $paymentIntent->id;
      // this $intent is what I want to store in my database
      $stripe = new \Stripe\StripeClient($stripeSecretKey);
      $metadata_order_id = $stripe->checkout->sessions->retrieve('id', []); // Fatal error</b>: 
      //  Uncaught (Status 404) (Request req_iw3WuCrSgr8pyD) No such checkout.session: id
      // And metadata is not expandable, so that the metadata_order_id can't be reached directly
      $query = 'UPDATE items_cdes SET id_stripe = "'.$intent.'" WHERE order_id = "'.$metadata_order_id.'"';
      $statement = $connect->prepare($query);
      $statement->execute();
//    I tried with the checkout.session.completed event, but what I want is the confirmation that payment succeded
//    case 'checkout.session.completed':
//    $metadata = $event->data->object;
//    $metadata_order_id = $metadata->order_id;
//    ...
    break;
    case 'payment_method.attached':
      $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
      // handlePaymentMethodAttached($paymentMethod);
    break;
        
    // ... handle other event types
    default:
        echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);