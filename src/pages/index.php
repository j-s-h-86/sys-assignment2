<?php
require_once ("src/Models/products.php");
require_once ("src/Models/Database.php");
$dbContext = new DBContext();
$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="/vite.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Webshop</title>
  <link rel="stylesheet" href="./src/style/index.css">
  <script src="https://kit.fontawesome.com/f3df6af664.js" crossorigin="anonymous"></script>
</head>

<body>
  <div id="root">
    <header>
      <?php
      $categories = $dbContext->getAllCategories();
      foreach ($categories as $category) {
        echo "<a href='/viewCategory?id=$category->id'>$category->title</a>";
      }
      ?>

    </header>

    <section>
      <div class="startPageProducts">
        <table class="table">
          <thead>
            <tr>
              <th>Author<a href="?sortCol=author&sortOrder=asc"><i class="fa-solid fa-arrow-down-a-z"></i><a
                    href="?sortCol=author&sortOrder=desc"><i class="fa-solid fa-arrow-up-z-a"></i></a></th>
              <th>Title<a href="?sortCol=title&sortOrder=asc"><i class="fa-solid fa-arrow-down-a-z"></i><a
                    href="?sortCol=title&sortOrder=desc"><i class="fa-solid fa-arrow-up-z-a"></i></a></th>
              <th>Price<a href="?sortCol=price&sortOrder=asc"><i class="fa-solid fa-arrow-down-a-z"></i><a
                    href="?sortCol=price&sortOrder=desc"><i class="fa-solid fa-arrow-up-z-a"></i></a></th>
              <th>Category<a href="?sortCol=categoryId&sortOrder=asc"><i class="fa-solid fa-arrow-down-a-z"></i><a
                    href="?sortCol=categoryId&sortOrder=desc"><i class="fa-solid fa-arrow-up-z-a"></i></a></th>
              <th>In stock</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $products = $dbContext->getAllProducts($sortCol, $sortOrder);
            foreach ($products as $product) {
              echo "<tr>
                    <td>$product->author</td>
                    <td>$product->title</td>
                    <td>$product->price SEK</td>
                    <td>$product->categoryId</td>
                    <td>$product->stockLevel pcs</td>
                    <td><a href='product.php?id=$product->id&author=$product->author&title=$product->title'>Read more</a>
                    </tr>";
            }
            ;
            ?>
          </tbody>
        </table>
      </div>
    </section>


  </div>

  <script type="module" src="/src/main.tsx"></script>
</body>

</html>