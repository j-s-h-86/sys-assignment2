<?php

require_once ("src/Models/Category.php");
require_once ("src/Models/products.php");

class DBContext
{
    private $host = 'localhost';
    private $db = 'products';
    private $user = 'root';
    private $pass = 'root';
    private $charset = 'utf8mb4';

    private $pdo;

    function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db";
        $this->pdo = new PDO($dsn, $this->user, $this->pass);
        $this->initIfNotInitialized();
        $this->seedIfNotSeeded();
    }

    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');

    }



    function getAllProducts($sortCol, $sortOrder)
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
        $prep->setFetchMode(PDO::FETCH_CLASS, 'products');
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

    function getProductsByCategory($categoryId)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products WHERE categoryId = :categoryId');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['categoryId' => $categoryId]);
        return $prep->fetchAll();
    }



    function seedIfNotSeeded()
    {
        static $seeded = false;
        if ($seeded)
            return;
        $this->createIfNotExisting("Pär Lagerkvist", "Ångest", 125, 2, 1);
        $this->createIfNotExisting("Arthur Rimbaud", "En tid i helvetet", 110, 2, 2);
        $this->createIfNotExisting("Charles Baudelaire", "De Ondas Blommor", 89, 5, 1);
        $this->createIfNotExisting("Guillaume Apollinaire", "De elvatusen spöna", 119, 1, 2);
        $this->createIfNotExisting("Vladimir Majakovskij", "Ett moln i byxor", 199, 3, 1);
        $this->createIfNotExisting("Harry Crews", "Gospelsångaren", 149, 5, 2);
        $this->createIfNotExisting("Harry Crews", "Ormfesten", 149, 5, 2);
        $this->createIfNotExisting("JG Ballard", "Crash", 179, 2, 2);
        $this->createIfNotExisting("JG Ballard", "Skändlighetsutställningen", 139, 5, 2);
        $this->createIfNotExisting("Tristan Tzara", "Dada är allt!", 99, 4, 1);
        $this->createIfNotExisting("Friedich Nietzsche", "Antikrist", 199, 1, 3);
        $this->createIfNotExisting("Friedich Nietzsche", "Så Talade Zarathustra", 199, 2, 3);
        $this->createIfNotExisting("Emile Cioran", "Olägenheten i att vara född", 189, 1, 3);
        $this->createIfNotExisting("Emile Cioran", "Sammanfattning av sönderfallet", 179, 1, 3);
        $this->createIfNotExisting("Emile Cioran", "Bitterhetens Syllogismer", 199, 3, 3);
        $this->createIfNotExisting("Pär Lagerkvist", "Kaos", 99, 1, 2);
        $this->createIfNotExisting("Dennis Cooper", "Närmare", 109, 1, 2);
        $this->createIfNotExisting("Dennis Cooper", "Kluven", 109, 1, 2);
        $this->createIfNotExisting("Dennis Cooper", "The Sluts (import)", 199, 1, 2);
        $seeded = true;

    }

    function createIfNotExisting($author, $title, $price, $stockLevel, $categoryId)
    {
        $existing = $this->getProductByTitle($title);
        if ($existing) {
            return;
        }
        ;
        return $this->addProduct($author, $title, $price, $stockLevel, $categoryId);

    }

    function addCategory($title)
    {
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(["title" => $title]);
        return $this->pdo->lastInsertId();
    }

    function addProduct($author, $title, $price, $stockLevel, $categoryId)
    {

        $category = $this->getCategoryByTitle($categoryId);
        if ($category == false) {
            $this->addCategory($categoryId);
            $category = $this->getCategoryByTitle($categoryId);
        }
        $prep = $this->pdo->prepare('INSERT INTO products (author, title, price, stockLevel, categoryId) VALUES(:author, :title, :price, :stockLevel, :categoryId )');
        $prep->execute(["author" => $author, "title" => $title, "price" => $price, "stockLevel" => $stockLevel, "categoryId" => $categoryId]);
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
            `price` INT,
            `stockLevel` INT,
            `categoryId` INT NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`)
                REFERENCES category(id)
            ) ";

        $this->pdo->exec($sql);

        $initialized = true;
    }


}


?>