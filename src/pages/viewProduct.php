<?php
require_once ("src/Models/Database.php");
require_once ("src/Models/products.php");
require_once ("src/pages/layout/header.php");

$dbContext = new DBContext();
$id = $_GET['id'];

$book = $dbContext->getProduct($id);
layout_header("Kulturprofilens webshop");
?>

<html>

<head>
    <link rel="stylesheet" href="./src/style/product.css">
</head>
<script>
    async function addToCart(id) {
        const quantity = await ((await fetch(`/addtocart?id=${id}`)).text())
        document.getElementById("amount").innerText = quantity;
    }
</script>


<body>
    <div class="pageWrapper">
        <div class="bookPresentation">
            <div class="cover_container"><img class="bookCover" src="<?php echo $book->image; ?>"></div>
            <p>
                <?php echo $book->author; ?> - <?php echo $book->title; ?>
            </p>
            <button class="listbutton" onclick="javascript:addToCart(<?php echo $book->id ?>)">Lägg i
                varukorg</button>
        </div>
    </div>
</body>

</html>