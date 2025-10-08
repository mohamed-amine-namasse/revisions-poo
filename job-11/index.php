<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

require 'product.php';
require 'category.php';
require 'clothing.php';
require 'electronic.php';

$category1=new Category(4,'Vêtements', 'tous les vêtements');
$category2=new Category(1,'Electronique', 'Produits électroniques divers');

$clothing=new Clothing(77,'chemise',['https://picsum.photos/988/300'],100,'chemise de luxe',2,$category1->getId(),new DateTime(),new DateTime(),'XL','rouge',500);
var_dump($clothing);
echo "<br>";
echo "<br>";
$electronic=new Electronic(78,'TV',['https://picsum.photos/987/300'],1000,"grand télévision",2,$category2->getId(),new DateTime(),new DateTime(),'Sony',22);
var_dump($electronic);


