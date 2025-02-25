<?php
include('db.php');
$qry="
SELECT * FROM pdt_table ORDER BY id ASC
";
$stm=$connect->prepare($qry);
if($stm->execute()){
    $result = $stm->fetchAll();
    $output='';
    foreach($result as $row){
        $output .='<div class="col-md-3" style="margin-top:12px;">
        <div style="border:1px solid #333;back-ground-color:#f1f1f1; border-radius
        :5px; padding:16px; height:650px;" align="center">
        <img src="images/'.$row["image"].'" class="img img-thumbnail"><br>
        <h4 class="text-info"><small>'.$row["name"].'</small></h4>
        <h4 class="text-danger">$'.$row["price"].'</h4>
        <input type="text" name="qnty" id="qnty'.$row["id"].'" 
        class="form-control" value="1">
        <input type="hidden" name="hid_nam" id="name'.$row["id"].'" 
        value="'.$row["name"].'">
        <input type="hidden" name="hid_prc" id="price'.$row["id"].'" 
        value="'.$row["price"].'">
        <input type="button" name="add_to_cart" id="'.$row["id"].'" class="btn 
        btn-success form-control add_to_cart" value="Add to Cart" style="margin-top:2px;">
        </div>
        </div>';
       
    }
    echo $output;
}
?>