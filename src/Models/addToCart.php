<?php
require_once ("src/Models/Database.php");
$id = $_GET['id'] ?? "";


$dbContext = new DBContext();
$quantity = $dbContext->addToCart($id);

// $
echo json_encode($quantity);

?>