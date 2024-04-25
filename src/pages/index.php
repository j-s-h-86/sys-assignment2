<?php
require_once ("src/Models/products.php");
require_once ("src/Models/Database.php");
require_once ("src/pages/layout/header.php");

$dbContext = new DBContext();
$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
$id = $_Get['id'] ?? "";
$q = $_GET['q'] ?? "";
$pageSize = $_GET['pageSize'] ?? "8";
$pageNo = $_GET['pageNo'] ?? "1";
layout_header("Kulturprofilens Webshop");
?>

<!doctype html>
<html lang="en">

<script>
  async function addToCart(id) {
    const quantity = await ((await fetch(`/addtocart?id=${id}`)).text())
    document.getElementById("amount").innerText = quantity;
  }
</script>

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="/vite.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kulturprofilens Webshop</title>
  <link rel="stylesheet" href="./src/style/index.css">
  <script src="https://kit.fontawesome.com/f3df6af664.js" crossorigin="anonymous"></script>
</head>

<body>
  <div id="root">
    <section>
      <div class=" startPageProducts">
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th>Author<a href="?sortCol=author&sortOrder=asc"><i class="fa-solid fa-arrow-down-a-z"></i><a
                    href="?sortCol=author&sortOrder=desc"><i class="fa-solid fa-arrow-up-z-a"></i></a></th>
              <th>Title<a href="?sortCol=title&sortOrder=asc"><i class="fa-solid fa-arrow-down-a-z"></i><a
                    href="?sortCol=title&sortOrder=desc"><i class="fa-solid fa-arrow-up-z-a"></i></a></th>
              <th>Price<a href="?sortCol=price&sortOrder=asc"><i class="fa-solid fa-arrow-down-a-z"></i><a
                    href="?sortCol=price&sortOrder=desc"><i class="fa-solid fa-arrow-up-z-a"></i></a></th>
            </tr>
          </thead>
          <tbody>
            <?php

            $result = $dbContext->searchProduct($sortCol, $sortOrder, $q, $pageNo);
            foreach ($result["data"] as $product) {
              ?>
              <tr class="tabulator-row">
                <td>
                  <div class="coverContainer_listed"><img class="bookCover_listed" src="<?php echo $product->image; ?>">
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
                <td><button class="listbutton" onclick="javascript:addToCart(<?php echo $product->id ?>)">Lägg i
                    varukorg</button></td>
              </tr>
              <?php
            }
            ?>

            <!-- 
          <tbody>
            <?php
            $products = $dbContext->getAllProducts($sortCol, $sortOrder, $q);
            foreach ($products as $product) {
              ?>
              <tr class="tabulator-row">
                <td>
                  <div class="coverContainer_listed"><img class="bookCover_listed" src="<?php echo $product->image; ?>">
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
          </tbody> -->
        </table>

      </div>
    </section>
    <div class="paging">
      <?php
      for ($i = 1; $i <= $result["num_pages"]; $i++) {
        echo "<a class='page__button' href='?sortCol=$sortCol&sortOrder=$sortOrder&q=$q&pageNo=$i'>$i</a>&nbsp;";
      }
      ?>
    </div>

  </div>

  <script type=" module" src="/src/main.tsx"></script>
</body>

</html>