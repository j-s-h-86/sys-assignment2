<?php
require_once ("src/Models/Database.php");
require_once ("src/Models/products.php");
require_once ("src/pages/layout/header.php");
$dbContext = new DBContext();
$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
$id = $_GET['id'] ?? "";
$q = $_GET['q'] ?? "";

layout_header("Kulturprofilens webshop")
    ?>

<head>
    <link rel="stylesheet" href="./src/style/viewCategory.css">
</head>

<html>

<body>
    <div class="categoryProducts">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Author<a href="?sortCol=author&sortOrder=asc&id=<?php echo $id ?>"><i
                                class="fa-solid fa-arrow-down-a-z"></i><a
                                href="?sortCol=author&sortOrder=desc&id=<?php echo $id ?>"><i
                                    class="fa-solid fa-arrow-up-z-a"></i></a>
                    </th>
                    <th>Title<a href="?sortCol=title&sortOrder=asc&id=<?php echo $id ?>"><i
                                class="fa-solid fa-arrow-down-a-z"></i><a
                                href="?sortCol=title&sortOrder=desc&id=<?php echo $id ?>"><i
                                    class="fa-solid fa-arrow-up-z-a"></i></a>
                    </th>
                    <th>Price<a href="?sortCol=price&sortOrder=asc&id=<?php echo $id ?>"><i
                                class="fa-solid fa-arrow-down-a-z"></i><a
                                href="?sortCol=price&sortOrder=desc&id=<?php echo $id ?>"><i
                                    class="fa-solid fa-arrow-up-z-a"></i></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dbContext->getPopularProducts($sortCol, $sortOrder, $q) as $product) {
                    ?>
                    <tr class="tabulator-row">
                        <td>
                            <div class="coverContainer_listed"><img class="bookCover_listed"
                                    src="<?php echo $product->image; ?>">
                            </div>
                        </td>
                        <td>
                            <?php echo $product->author ?>
                        </td>
                        <td>
                            <a href="/viewProduct?id=<?php echo $product->id ?>">
                                <?php echo $product->title ?>
                            </a>
                        </td>
                        <td>
                            <?php echo $product->price ?> SEK
                        </td>
                        <td><button>Lägg i varukorg</button></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>