<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

require 'product.php';
require 'category.php';
require 'clothing.php';
require 'electronic.php';

$category=new Category(4,'Vêtements', 'tous les vêtements');
$product=new Product(77,'sac',['https://picsum.photos/957/300'],100,'petit sac',2,$category->getId(),new DateTime(),new DateTime());
var_dump($product);
echo "<br>";
echo "<br>";
$clothing=new Clothing('XL','rouge',500);
var_dump($clothing);
echo "<br>";
echo "<br>";
$electronic=new Electronic('TV',22);
var_dump($electronic);


