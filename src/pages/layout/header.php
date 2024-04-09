<?php
function layout_header(string $title)
{
    $dbContext = new DBContext();
    $sortOrder = $_GET['sortOrder'] ?? "";
    $sortCol = $_GET['sortCol'] ?? "";
    $q = $_GET['q'] ?? "";
    ?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <link rel="icon" type="image/svg+xml" href="/vite.svg" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>
            <?php echo $title; ?>
        </title>
        <link rel="stylesheet" href="./src/style/header.css">
        <script src="https://kit.fontawesome.com/f3df6af664.js" crossorigin="anonymous"></script>
        <script src="/js/main.js"></script>

    </head>
    <header>
        <div>
            <nav>
                <ul class="categoryNames">
                    <?php foreach ($dbContext->getAllCategories() as $category) { ?>
                        <li>
                            <h3><a href='/viewCategory?id=<?php echo $category->id ?>'>
                                    <?php echo $category->title ?>
                            </h3></a>
                        </li>
                    <?php } ?>
                </ul>
                <form method="GET">
                    <input type="text" placeholder="Sök produkt" name="q" value="<?php echo $q; ?>" />
                    <button>Sök</button>
                </form>
            </nav>
        </div>
    </header>
    <?php
}
?>