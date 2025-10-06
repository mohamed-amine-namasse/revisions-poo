<?php
include "category.php";

$category = new Category(1, "Électronique", "Produits électroniques divers");

$product1 = new Product(100, "Smartphone",['https://picsum.photos/200/300'], 299,'A nice T-shirt', 50, $category->getId());

var_dump($product1);
echo "<br>";
echo "<br>";
$product2 = new Product();
var_dump($product2);


