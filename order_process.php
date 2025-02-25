<?php
session_start();
$total_price=0;
$item_details ='';
$order_details='<div class="table-responsive" id="order_table">
<table class="table table-bordered table-striped">
<tr>
    <th>Product Name</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Total</th>
</tr>
';

if(!empty($_SESSION["shopping_cart"])){
    foreach($_SESSION["shopping_cart"] as $keys => $values){
      $order_details .= '<tr>
      <td>'.$values["pdt_name"].'</td>
      <td>'.$values["pdt_qnty"].'</td>
      <td align="right">$ '.$values["pdt_price"].'</td>
      <td align="right">$ '.number_format($values["pdt_qnty"]*
      $values["pdt_price"],2).'</td>';
      
      $total_price=$total_price+($values["pdt_qnty"]*
      $values["pdt_price"]);
      $item_details .=$values["pdt_name"]. ', ';
    }
    $item_details=substr($item_details,0,-2);
    $order_details .='<tr>
    <td colspan="3" align="right">Total</td>
    <td align="right">$ '.number_format($total_price,2).'</td>
    </tr>'; 
  }

  $order_details .='</table>
  </div>';
//   $data=array(
//     'cart_details'  =>$order_details,
//     'total_price'   =>'$' . number_format($total_price,2)
    
//   );
//   echo json_encode($data);
?>
<!DOCTYPE html>
<html>
 <head>
  <title>PHP Shopping Cart with Stripe Payment Integration</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://js.stripe.com/v2/"></script>
  <script src="js/jquery.creditCardValidator.js"></script>
  <style>
  .popover
  {
      width: 100%;
      max-width: 800px;
  }
  .require
  {
   border:1px solid #FF0000;
   background-color: #cbd9ed;
  }
  </style>
 </head>
 <body>
  <div class="container">
   <br />
   <h3 align="center"><a href="index.php">Order Process</a></h3>
   <br />
   <span id="message"></span>
   <div class="panel panel-default">
    <div class="panel-heading">Order Process</div>
    <div class="panel-body">
     <form method="post" id="order_process_form" action="payment.php">
      <div class="row">
       <div class="col-md-8" style="border-right:1px solid #ddd;">
        <h4 align="center">Customer Details</h4>
        <div class="form-group">
         <label for="customer_name"><b>Card Holder Name <span class="text-danger">*</span></b></label>
               <input type="text" name="customer_name" id="customer_name" class="form-control" value="" />
               <span id="error_customer_name" class="text-danger"></span>
           </div>
           <div class="form-group">
            <label for="email_address"><b>Email Address <span class="text-danger">*</span></b></label>
            <input type="text" name="email_address" id="email_address" class="form-control" value="" />
            <span id="error_email_address" class="text-danger"></span>
           </div>
           <div class="form-group">
            <label for="customer_address"><b>Address <span class="text-danger">*</span></b></label>
            <textarea name="customer_address" id="customer_address" class="form-control"></textarea>
            <span id="error_customer_address" class="text-danger"></span>
           </div>
           <div class="row">
            <div class="col-sm-6">
             <div class="form-group">
              <label for="customer_city"><b>City <span class="text-danger">*</span></b></label>
              <input type="text" name="customer_city" id="customer_city" class="form-control" value="" />
              <span id="error_customer_city" class="text-danger"></span>
             </div>
            </div>
            <div class="col-sm-6">
             <div class="form-group">
              <label for="customer_pin"><b>Zip <span class="text-danger">*</span></b></label>
              <input type="text" name="customer_pin" id="customer_pin" class="form-control" value="" />
              <span id="error_customer_pin" class="text-danger"></span>
             </div>
            </div>
           </div>
           <div class="row">
            <div class="col-sm-6">
             <div class="form-group">
              <label for="customer_state"><b>State </b></label>
              <input type="text" name="customer_state" id="customer_state" class="form-control" value="" />
             </div>
            </div>
            <div class="col-sm-6">
             <div class="form-group">
              <label for="customer_country"><b>Country <span class="text-danger">*</span></b></label>
              <input type="text" name="customer_country" id="customer_country" class="form-control" />
              <span id="error_customer_country" class="text-danger"></span>
             </div>
            </div>
           </div>
           <hr />
        <div align="center">
        <input type="hidden" name="total_amount" 
         value="<?php echo $total_price; ?>" />
         <input type="hidden" name="currency_code" value="eur" />
         <input type="hidden" name="item_details" 
         value="<?php echo $item_details; ?>" />
         <button type="submit"
        >Payer</button>
        </div>
        <br />
       </div>
       <div class="col-md-4">
        <h4 align="center">Order Details</h4>
        <?php
        echo $order_details;
        ?>
       </div>
      </div>
     </form>
    </div>
   </div>
  </div>
 </body>
</html>
<?php
include('orderjs.php');
?>
