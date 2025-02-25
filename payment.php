<?php
session_start();
include('db.php');
require_once 'secrets.php';

// condition sur frais de port

if ($_POST["total_amount"] > 40) {
  $port = '0';
} else {
  $port = "500";
}


// connection à la base clients_cdes
try{
    $order_data = array(
    ":date" => date("Y-m-d H:i:s"),
    ":montant" => $_POST["total_amount"]*100,
    ":port" => $port,
    ":description" => $_POST["item_details"],
    ":email"  => $_POST['email_address'],
    ":nom"  => $_POST["customer_name"],
    ":prenom"  => "John",
    ":adresse1"  => $_POST['customer_address'],
    ":adresse2"   => "---",
    ":ville"  => $_POST['customer_city'],
    ":CP"  => 99999,
    );
    $query =  "INSERT INTO clients_cdes (date, montant, port, description, email, nom, prenom, adresse1, adresse2, ville, CP) 
        VALUES (:date, :montant, :port, :description, :email, :nom, :prenom, :adresse1, :adresse2, :ville, :CP)";
    $statement = $connect->prepare($query);
//    var_dump($order_data);
    $statement->execute($order_data);
}

catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
}


// connection à la base items_cdes

$order_id = $connect->lastInsertId();

foreach($_SESSION["shopping_cart"] as $keys => $values){
$order_item_data = array(
    ':order_id'  => $order_id,
    ':order_item_name' => $values["pdt_name"],
    ':order_item_quantity' => $values["pdt_qnty"],
    ':order_item_price' => $values["pdt_price"],
    ':id_stripe' => "en attente"
);

$query = "INSERT INTO items_cdes (order_id, order_item_name, order_item_qnty, order_item_price, id_stripe) 
VALUES (:order_id, :order_item_name, :order_item_quantity, :order_item_price, :id_stripe)";
$statement = $connect->prepare($query);
//var_dump($order_item_data);
$statement->execute($order_item_data);
}

// connection à stripe

require_once 'vendor/autoload.php';
\Stripe\Stripe::setApiKey($stripeSecretKey);
\Stripe\Stripe::setApiVersion('2025-01-27.acacia');

$checkout_session = \Stripe\Checkout\Session::create([
    'shipping_options' => [
        [
          'shipping_rate_data' => [
            'type' => 'fixed_amount',
            'fixed_amount' => [
              'amount' => $port,
              'currency' => 'eur',
            ],
            'display_name' => 'Au delà de 40€ expédition gratuite',
            'delivery_estimate' => [
              'minimum' => [
                'unit' => 'business_day',
                'value' => 5,
              ],
              'maximum' => [
                'unit' => 'business_day',
                'value' => 7,
              ],
            ],
          ],
        ],
    ],
    "line_items" => [[
        "price_data" => [
            "product_data" => [
                "name" => $_POST["item_details"],
            ],
            "currency" => $_POST["currency_code"],
            "unit_amount" => $_POST["total_amount"]*100,
        ],       
        "quantity" =>  1,
    ]],  
    "mode" => "payment",
    'success_url' => $YOUR_DOMAIN . '/after-checkout.php?session_id={CHECKOUT_SESSION_ID}',
    "cancel_url" => $YOUR_DOMAIN . '/cancel.php',
    "locale" => "fr",
    "metadata" => [
        "order_id" => $order_id
    ]
]);

//unset($_SESSION["shopping_cart"]);

http_response_code(303);
header("Location:" . $checkout_session->url);

?>