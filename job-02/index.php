<?php
include "category.php";

$category = new Category(1, "Électronique", "Produits électroniques divers");

$product = new Product(100, "Smartphone",['https://picsum.photos/200/300'], 299,'A nice T-shirt', 50, $category->getId());

// Affichage
echo "Produit : " . $product->getName() . "<br>";
echo "Catégorie ID : " . $product->getCategoryId() . "<br>";
echo "Créé le : " . $product->getCreatedAt()->format("Y-m-d H:i:s") . "<br>";