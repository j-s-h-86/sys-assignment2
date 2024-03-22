<?php
require_once ("src/Models/products.php");
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="/vite.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Webshop</title>
</head>

<body>
  <div id="root">
    <header>
    </header>

    <section>
      <div class>
        <table class="table">
          <thead>
            <tr>
              <th>Author</th>
              <th>Title</th>
              <th>Price</th>
              <th>In stock</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $products = getAllProducts();
            foreach ($products as $product) {
              echo "<tr>
                    <td>$product->author</td>
                    <td>$product->title</td>
                    <td>$product->price SEK</td>
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