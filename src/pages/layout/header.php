<?php
function layout_header(string $title)
{
    $dbContext = new DBContext();
    $q = $_GET['q'] ?? "";
    $id = $_GET['id'] ?? "";
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
        <link rel="stylesheet" href="/src/style/header.css">
        <script src="https://kit.fontawesome.com/f3df6af664.js" crossorigin="anonymous"></script>
        <script src="/js/main.js"></script>

    </head>
    <header>
        <div class="user-info">
            <?php
            if (!$dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
                ?>
                <a href="/users/login">Logga in</a>
                <a href="/users/register">Registrera</a>
                <?php
            } else {
                ?>
                <h2>Welcome!</h2>
                <a href="/users/logout"><i class="fas fa-sign-out-alt"></i>Logga ut</a>
                <?php
            }
            ?>
        </div>

        <div>
            <a><i class="fa-solid fa-cart-shopping"></i></a>
            <nav>
                <ul class="categoryNames">
                    <?php foreach ($dbContext->getAllCategories() as $category) { ?>
                        <li>
                            <h3><a href='/viewCategory?id=<?php echo $category->id ?>'>
                                    <?php echo $category->title ?>
                                </a></h3>
                        </li>
                    <?php } ?>
                    <li>
                        <h3><a href='/viewPopular'>Populärast</a></h3>
                </ul>
                <form method="GET">
                    <input type="text" placeholder="Sök produkt" name="q" value="<?php echo $q; ?>" />
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <button>Sök</button>
                </form>
            </nav>
        </div>
    </header>
    <?php
}
?>