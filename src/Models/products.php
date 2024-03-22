<?php
class Product
{
    public $id;
    public $author;
    public $title;
    public $image;
    public $price;
    public $stockLevel;
    public $categoryName;

    function __construct($id, $author, $title, $image, $price, $stockLevel, $categoryName)
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->image = $image;
        $this->price = $price;
        $this->stockLevel = $stockLevel;
        $this->categoryName = $categoryName;
    }
}
;

$productList = [
    new Product(1, "Pär Lagerkvist", "Ångest", "", 150, 5, "Books"),
    new Product(2, "Arthur Rimbaud", "En tid i helvetet", "", 150, 5, "Books"),
    new Product(3, "Charles Baudelaire", "De Ondas Blommor", "", 150, 5, "Books"),
    new Product(4, "Guillaume Apollinaire", "De elvatusen spöna", "", 150, 5, "Books"),
    new Product(5, "Vladimir Majakovskij", "Ett moln i byxor", "", 150, 5, "Books"),
    new Product(6, "Harry Crews", "Gospelsångaren", "", 150, 5, "Books"),
    new Product(7, "Harry Crews", "Ormfesten", "", 150, 5, "Books"),
    new Product(8, "JG Ballard", "Crash", "", 150, 5, "Books"),
    new Product(9, "JG Ballard", "Skändlighetsutställningen", "", 150, 5, "Books"),
    new Product(10, "Tristan Tzara", "Dada är allt!", "", 150, 5, "Books")

];

function getAllProducts()
{
    global $productList;
    return $productList;
}
?>