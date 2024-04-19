<?php
require_once ("src/Models/Category.php");
require_once ("src/Models/products.php");
require_once ("src/Models/UserDatabase.php");
require 'vendor/autoload.php';

class DBContext
{
    private $pdo;
    private $usersDatabase;

    function getUsersDatabase()
    {
        return $this->usersDatabase;
    }

    function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(".");
        $dotenv->load();
        $host = $_ENV['host'];
        $db = $_ENV['db'];
        $user = $_ENV['user'];
        $pass = $_ENV['pass'];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->usersDatabase = new UserDatabase($this->pdo);
        $this->initIfNotInitialized();
        $this->seedIfNotSeeded();
    }
    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');

    }



    function getAllProducts($sortCol, $sortOrder, $q)
    {
        if ($sortCol == null) {
            $sortCol = "author";
        }
        if ($sortOrder == null) {
            $sortOrder = "Asc";
        }
        $sql = "SELECT * FROM products ORDER BY $sortCol $sortOrder";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, 'Product');
    }
    function getProduct($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }
    function getProductByTitle($title)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }

    function getCategoryByTitle($title): Category|false
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }

    function getProductsByCategory($categoryId, $sortOrder, $sortCol, $q)
    {

        if ($sortCol == null) {
            $sortCol = "title";
        }
        if ($sortOrder == null) {
            $sortOrder = "ASC";
        }
        $sql = "SELECT * FROM products WHERE categoryId = :categoryId ";
        $paramsArray = ["categoryId" => $categoryId];
        if ($q != null && strlen($q) > 0) {
            $sql = $sql . " and ( author like :q ";
            $sql = $sql . " OR  title like :q) ";
            $paramsArray["q"] = '%' . $q . '%';
        }


        $sql .= " ORDER BY $sortCol $sortOrder ";

        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute($paramsArray);


        return $prep->fetchAll();
    }

    function getPopularProducts($sortCol, $sortOrder, $q)
    {
        return $this->pdo->query('select * from products order by popularity desc limit 10')->fetchAll(
            PDO::FETCH_CLASS,
            'Product'
        );

    }

    function searchProduct($sortCol, $sortOrder, $q, $pageNo = 1, $pageSize = 8)
    {
        if ($sortCol == null) {
            $sortCol = "title";
        }
        if ($sortOrder == null) {
            $sortOrder = "ASC";
        }
        $sql = "SELECT * FROM products ";
        $paramsArray = [];
        $addedWhere = false;
        if ($q != null && strlen($q) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " author like :q ";
            $sql = $sql . " OR  title like :q ";
            $paramsArray["q"] = '%' . $q . '%';
        }


        $sql .= " ORDER BY $sortCol $sortOrder ";

        $sqlCount = str_replace("SELECT * FROM ", "SELECT CEIL (COUNT(*)/$pageSize) FROM ", $sql);
        $offset = ($pageNo - 1) * $pageSize;
        $sql .= " limit $offset, $pageSize";

        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute($paramsArray);
        $data = $prep->fetchAll();

        $prep2 = $this->pdo->prepare($sqlCount);
        $prep2->execute($paramsArray);

        $num_pages = $prep2->fetchColumn();

        $arr = ["data" => $data, "num_pages" => $num_pages];
        return $arr;
    }


    function seedIfNotSeeded()
    {
        static $seeded = false;
        if ($seeded)
            return;
        $this->createIfNotExisting("Pär Lagerkvist", "Ångest", "./assets/angest.jpg", 125, 2, 1, 3);
        $this->createIfNotExisting("Arthur Rimbaud", "En tid i helvetet", "./assets/rimbaud-tid.jpg", 110, 2, 2, 6);
        $this->createIfNotExisting("Charles Baudelaire", "De Ondas Blommor", "./assets/baudelaire.jpg", 89, 5, 1, 1);
        $this->createIfNotExisting("Guillaume Apollinaire", "De elvatusen spöna", "./assets/apollinaire.jpg", 119, 1, 2, 9);
        $this->createIfNotExisting("Vladimir Majakovskij", "Ett moln i byxor", "./assets/byxor.jpg", 199, 3, 1, 4);
        $this->createIfNotExisting("Harry Crews", "Gospelsångaren", "./assets/gospelsangaren.jpg", 149, 5, 2, 3);
        $this->createIfNotExisting("Harry Crews", "Ormfesten", "./assets/ormfesten.jpg", 149, 5, 2, 8);
        $this->createIfNotExisting("JG Ballard", "Crash", "./assets/jgcrash.jpg", 179, 2, 2, 7);
        $this->createIfNotExisting("JG Ballard", "Skändlighetsutställningen", "./assets/jgatrocity.jpg", 139, 5, 2, 3);
        $this->createIfNotExisting("Tristan Tzara", "Dada är allt!", "./assets/tzaradada.jpg", 99, 4, 1, 5);
        $this->createIfNotExisting("Friedich Nietzsche", "Antikrist", "./assets/nietzscheanti.jpg", 199, 1, 3, 6);
        $this->createIfNotExisting("Friedich Nietzsche", "Så Talade Zarathustra", "./assets/nietzschezarathustra.jpg", 199, 2, 3, 7);
        $this->createIfNotExisting("Emile Cioran", "Om olägenheten i att vara född", "./assets/olagenheten.jpg", 189, 1, 3, 6);
        $this->createIfNotExisting("Emile Cioran", "Sammanfattning av sönderfallet", "./assets/Cioransammanfattning.jpg", 179, 1, 3, 8);
        $this->createIfNotExisting("Emile Cioran", "Bitterhetens Syllogismer", "./assets/bitterhetens.jpg", 199, 3, 3, 2);
        $this->createIfNotExisting("Pär Lagerkvist", "Kaos", "./assets/kaos.jpg", 99, 1, 2, 5);
        $this->createIfNotExisting("Dennis Cooper", "Närmare", "./assets/narmare.jpg", 109, 1, 2, 8);
        $this->createIfNotExisting("Dennis Cooper", "Kluven", "./assets/kluven.jpg", 109, 1, 2, 4);
        $this->createIfNotExisting("Dennis Cooper", "The Sluts (import)", "./assets/cooper-sluts.jpg", 199, 1, 2, 5);
        $this->createIfNotExisting("Thomas Moore", "Alone", "./assets/moorealone.jpg", 299, 1, 2, 7);
        $this->createIfNotExisting("Mike Williams", "Cancer As A Social Activity (import)", "./assets/cancer.jpg", 299, 1, 1, 1);

        $seeded = true;

    }

    function createIfNotExisting($author, $title, $image, $price, $stockLevel, $categoryId, $popularity)
    {
        $existing = $this->getProductByTitle($title);
        if ($existing) {
            return;
        }
        ;
        return $this->addProduct($author, $title, $image, $price, $stockLevel, $categoryId, $popularity);

    }

    function addCategory($title)
    {
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(["title" => $title]);
        return $this->pdo->lastInsertId();
    }

    function addProduct($author, $title, $image, $price, $stockLevel, $categoryId, $popularity)
    {

        $category = $this->getCategoryByTitle($categoryId);
        if ($category == false) {
            $this->addCategory($categoryId);
            $category = $this->getCategoryByTitle($categoryId);
        }
        $prep = $this->pdo->prepare('INSERT INTO products (author, title, image, price, stockLevel, categoryId, popularity) VALUES(:author, :title, :image, :price, :stockLevel, :categoryId, :popularity)');
        $prep->execute(["author" => $author, "title" => $title, "image" => $image, "price" => $price, "stockLevel" => $stockLevel, "categoryId" => $categoryId, "popularity" => $popularity]);
        return $this->pdo->lastInsertId();

    }

    function addUser($UserName, $Password, $GivenName, $Surname, $StreetAddress, $City, $ZipCode, $Country, $PersonalNumber, $EmailAddress)
    {
        $prep = $this->pdo->prepare("INSERT INTO User
    (UserName, Password) VALUES(:UserName, :Password)");
        $prep->execute([
            "UserName" => $UserName,
            "Password" => $Password
        ]);

        $prep = $this->pdo->prepare("INSERT INTO UserDetails
                        (GivenName, Surname, StreetAddress, City, ZipCode, Country, PersonalNumber, EmailAddress)
                    VALUES(:GivenName, :Surname, :Streetaddress, :City, :Zipcode, :Country, :PersonalNumber, :EmailAddress);
        ");
        $prep->execute([
            "GivenName" => $GivenName,
            "Surname" => $Surname,
            "Streetaddress" => $StreetAddress,
            "City" => $City,
            "ZipCode" => $ZipCode,
            "Country" => $Country,
            "PersonalNumber" => $PersonalNumber,
            "EmailAddress" => $EmailAddress
        ]);
        return $this->pdo->lastInsertId();

    }
    function initIfNotInitialized()
    {

        static $initialized = false;
        if ($initialized)
            return;


        $sql = "CREATE TABLE IF NOT EXISTS `category` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
            ) ";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `author` varchar(200) NOT NULL,
            `title` varchar(200) NOT NULL,
            `image` varchar(200) NOT NULL,
            `price` INT,
            `stockLevel` INT,
            `categoryId` INT NOT NULL,
            `popularity`INT, 
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`)
                REFERENCES category(id)
            ) ";

        $this->pdo->exec($sql);

        $this->usersDatabase->setupUsers();
        $this->usersDatabase->seedUsers();

        $initialized = true;
    }


}


?>