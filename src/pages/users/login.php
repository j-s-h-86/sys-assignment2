<?php
require 'vendor/autoload.php';
require_once ('src/Models/Database.php');
require_once ('src/pages/layout/header.php');


$dbContext = new DbContext();
$message = "";
$username = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $dbContext->getUsersDatabase()->getAuth()
            ->login($username, $password);
        header('Location: /');
        exit;
    } catch (Exception $e) {
        $message = "Could not login";

    }
}
layout_header("Kulturprofilens webshop")
    ?>

<head>
    <link rel="stylesheet" href="/src/style/login.css">
</head>
<html>

<body>
    <?php echo $dbContext->getUsersDatabase()->getAuth()->isLoggedIn(); ?>
    <main>
        <section class="login_form">
            <form method="post" class="form">
                <table width="100%">
                    <thead>
                        <tr>
                            <th><span class="las la-sort"></span> </th>
                            <th width="90%"><span class="las la-sort"></span> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><label for="name">Användarnamn</label></th>
                            <td>
                                <input class="form-control" type="text" name="username" value="<?php echo $username ?>">

                            </td>
                        </tr>

                        <tr>
                            <th><label for="name">Lösenord</label></th>
                            <td>
                                <input class="form-control" type="password" name="password">

                            </td>
                        </tr>


                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="listbutton" value="Logga in">
                                &nbsp;&nbsp;&nbsp;
                                <a href="/" class="listbutton">Avbryt</a>
                            </td>
                        </tr>
                    </tbody>


                </table>
            </form>


        </section>
    </main>



    <?php
    ?>

</body>

</html>