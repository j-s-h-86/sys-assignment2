<?php
require_once ("src/Models/Database.php");
require_once ("src/Models/products.php");

$dbContext = new DBContext();
$id = $_GET['id'];

$book = $dbContext->getProduct($id);
?>

<head>
    <link rel="stylesheet" href="./src/style/product.css">
</head>
<html>


<body>
    <div class="pageWrapper">
        <div class="bookPresentation">
            <p>
                <?php echo $book->author; ?>
            </p>
            <p>
                <?php echo $book->title; ?>
            </p>
        </div>
    </div>
</body>

</html>