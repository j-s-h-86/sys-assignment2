<?php
require_once ("src/Models/Database.php");
require_once ("src/Utils/Validator.php");
require_once ("src/Models/User.php");
require_once ("src/pages/layout/Header.php");


$dbContext = new DBContext();


$customer = new User();
$message = "";

$v = new Validator($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer->UserName = $_POST['UserName'];
    $customer->Password = $_POST['Password'];
    $customer->GivenName = $_POST['GivenName'];
    $customer->Surname = $_POST['Surname'];
    $customer->StreetAddress = $_POST['StreetAddress'];
    $customer->City = $_POST['City'];
    $customer->ZipCode = $_POST['ZipCode'];
    $customer->Country = $_POST['Country'];
    $customer->EmailAddress = $_POST['EmailAddress'];


    // $v->field(`UserName`)->required()->min_len(5)->max_len(16)->must_contain('@#$&')->must_contain('a-z')->must_contain('A-Z')->must_contain('0-9');
    // $v->field('Password')->required()->min_len(8)->max_len(16)->must_contain('@#$&')->must_contain('a-z')->must_contain('A-Z')->must_contain('0-9');
    // $v->field('GivenName')->required()->alpha([' '])->min_len(1)->max_len(200);
    // $v->field('Surname')->required()->alpha([' '])->min_len(2)->max_len(200);
    // $v->field('StreetAddress')->required()->alpha()->numeric();//vad?
    // $v->field('City')->required()->alpha(' ');
    // $v->field('ZipCode')->required()->numeric();
    // $v->field('Country')->required()->alpha();
    $v->field('EmailAddress')->required()->email();
    if ($v->is_valid()) {
        $dbContext->addUser(
            $customer->UserName,
            $customer->Password,
            $customer->GivenName,
            $customer->Surname,
            $customer->StreetAddress,
            $customer->City,
            $customer->ZipCode,
            $customer->Country,
            $customer->EmailAddress
        );
        header("Location: /"); // uppmaning Location = byt location till det jag säger
        exit;
    } else {
        $message = "FIXA FEL";
    }

}

layout_header("Kulturprofilens webshop")
    ?>

<head>
    <link rel="stylesheet" href="/src/style/register.css">
</head>
<html>

<body>
    <section>
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
                            <input class="form-control" type="text" name="UserName"
                                value="<?php echo $customer->UserName ?>">

                        </td>
                    </tr>
                    <tr>
                        <th><label for="name">Lösenord</label></th>
                        <td>
                            <input class="form-control" type="text" name="Password"
                                value="<?php echo $customer->Password ?>">

                        </td>
                    </tr>

                    <tr>
                        <th><label for="name">Förnamn</label></th>
                        <td>
                            <input class="form-control" type="text" name="GivenName"
                                value="<?php echo $customer->GivenName ?>">
                            <span class="alert"><?php echo $v->get_error_message('GivenName'); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <th><label for="name">Efternamn</label></th>
                        <td>
                            <input class="form-control" type="text" name="Surname"
                                value="<?php echo $customer->Surname ?>">
                            <span class="alert"><?php echo $v->get_error_message('Surname'); ?></span>

                        </td>
                    </tr>


                    <tr>
                        <th><label for="name">Gatuadress</label></th>
                        <td>
                            <input class="form-control" type="text" name="StreetAddress"
                                value="<?php echo $customer->StreetAddress ?>">

                        </td>
                    </tr>

                    <tr>
                        <th><label for="name">Postort</label></th>
                        <td>
                            <input class="form-control" type="text" name="City" value="<?php echo $customer->City ?>">

                        </td>
                    </tr>

                    <tr>
                        <th><label for="name">Postnummer</label></th>
                        <td>
                            <input class="form-control" type="text" name="ZipCode"
                                value="<?php echo $customer->ZipCode ?>">

                        </td>
                    </tr>


                    <tr>
                        <th><label for="name">Land</label></th>
                        <td>
                            <input class="form-control" type="text" name="Country"
                                value="<?php echo $customer->Country ?>">

                        </td>
                    </tr>
                    <tr>
                        <th><label for="name">EmailAddress</label></th>
                        <td>
                            <input class="form-control" type="email" name="EmailAddress"
                                value="<?php echo $customer->EmailAddress ?>">

                        </td>
                    </tr>
                </tbody>

            </table>
            <input type="submit" value="Spara" />
        </form>
    </section>
</body>

</html>