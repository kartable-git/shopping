<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <style>
            .popover{
                width: 100%;
                max-width: 800px;
            }
        </style>
</head>
<body style="background-image:url('shop.jpg')">
    <div class="container">
        <br>
        <h3 align="center">Shopping Cart with Stripe Payment Gateway</h3>     
        <br>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target=".navbar-collapse">
                <span class="sr-only">Menu</span>
                <span class="glyphicon glyphicon-menu-hamburger"></span>
                </button>
                <a href="/" class="navbar-brand">jasShop</a>
                </div>

                <div id="navbar-cart" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a class="btn" data-placement="bottom" title="Shopping Cart" id="cart-popover">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                <span class="badge"></span>
                                <span class="total_price">$0.00</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
     if(isset($_SESSION["success_message"])){
     echo '<div class="alert alert-success">'.$_SESSION["success_message"].'</div>';
     unset($_SESSION["success_message"]);
    }
     ?> 
        <div id="popover_content_wrapper" style="display: none;">
            <span id="cart_details"></span>
            <div align="right">
                <a href="order_process.php" class="btn btn-primary" id="check_out_cart">
                    <span class="glyphicon glyphicon-shopping-cart"></span>Check Out
                </a>
                <a href="#" class="btn btn-default" id="clear_cart">
                    <span class="glyphicon glyphicon-trash"></span>Clear
                </a>
            </div>
        </div>
 
          <div id="display_item" class="row">

          </div>
<br><br>
    </div>
</body>
</html>
<?php
include('jquery.php');
?>