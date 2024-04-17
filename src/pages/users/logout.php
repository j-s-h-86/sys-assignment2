<?php
require 'vendor/autoload.php';
require_once ('src/Models/Database.php');
require_once ('src/pages/layout/header.php');


$dbContext = new DBContext();

$dbContext->getUsersDatabase()->getAuth()->logOut();
header('Location: /');
exit;