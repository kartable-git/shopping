<?php
$connect = new PDO("mysql:host=localhost;dbname=shopping","root","");
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>