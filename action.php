<?php
session_start();
if(isset($_POST["action"])){
    if($_POST["action"]=='add'){
        if(isset($_SESSION["shopping_cart"])){
          $is_avl =0;
          foreach($_SESSION["shopping_cart"] as $keys => $values){
              if($_SESSION["shopping_cart"][$keys]['pdt_id']==
              $_POST['pdt_id']){
                  $is_avl++;
                  $_SESSION["shopping_cart"][$keys]['pdt_qnty']=
                  $_SESSION["shopping_cart"][$keys]['pdt_qnty']+
                  $_POST['pdt_qnty'];
              }
          }
          if($is_avl==0){
            $item_array=array(
                'pdt_id' =>$_POST['pdt_id'],
                'pdt_name' =>$_POST['pdt_name'],
                'pdt_price' =>$_POST['pdt_price'],
                'pdt_qnty' =>$_POST['pdt_qnty']
            );
            $_SESSION["shopping_cart"][]=$item_array;
          }
        }else{
           $item_array=array(
               'pdt_id' =>$_POST['pdt_id'],
               'pdt_name' =>$_POST['pdt_name'],
               'pdt_price' =>$_POST['pdt_price'],
               'pdt_qnty' =>$_POST['pdt_qnty']
           );
           $_SESSION["shopping_cart"][]=$item_array;
        }
    }
    if($_POST["action"]=='rmv'){
        foreach($_SESSION["shopping_cart"] as $keys => $values){
            if($values['pdt_id']==$_POST['pdt_id']){
                unset($_SESSION['shopping_cart'][$keys]);
            }
        }
    }
    if($_POST["action"]=='empty'){
        
         
            unset($_SESSION['shopping_cart']);
          
        
    }
}
?>