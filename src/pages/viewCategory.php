<?php
require_once ("src/Models/Database.php");
$dbContext = new DBContext();
$id = $_GET['id'];
?>
<html>

<body>
    <h1>Här visas böcker i vald kategori.</h1>
    <ul>
        <?php
        $booksInCategory = $dbContext->getProductsByCategory($id);
        foreach ($booksInCategory as $book) {
            echo "<li><p>$book->author - $book->title</li>";
        }
        ?>
</body>

</html>