<?php
require_once ("src/Models/Database.php");
require_once ("src/Models/products.php");
require_once ("src/pages/layout/header.php");

$dbContext = new DBContext();
$id = $_GET['id'];

$book = $dbContext->getProduct($id);
layout_header("Kulturprofilens webshop");
?>

<head>
    <link rel="stylesheet" href="./src/style/product.css">
</head>
<html>


<body>
    <div class="pageWrapper">
        <div class="bookPresentation">
            <div class="cover_container"><img class="bookCover" src="<?php echo $book->image; ?>"></div>
            <p>
                <?php echo $book->author; ?> - <?php echo $book->title; ?>
            </p>
        </div>
    </div>
</body>

</html>