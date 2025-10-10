<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

require 'product.php';
require 'category.php';
require 'clothing.php';
require 'electronic.php';



$manteau=new Clothing(null,'manteau',['https://picsum.photos/9000/3000'],220,'manteau enfant',2,4,new DateTime(),new DateTime(),'S','vert','coton',222);
var_dump($manteau->addStocks(50));//on ajoute 50 au stock de manteau
echo "<br>";
echo "<br>";
var_dump($manteau->removeStocks(5));//on ajoute 50 au stock de manteau
echo "<br>";
echo "<br>";
echo $manteau->getStock();
echo "<br>";
$electonic=new Electronic (null,'PS2',['https://picsum.photos/98/300'],1000,"console",2,4,new DateTime(),new DateTime(),'Sony',22);
var_dump($electonic->addStocks(40));//on ajoute 50 au stock de manteau
echo "<br>";
echo "<br>";
var_dump($electonic->removeStocks(5));//on ajoute 50 au stock de manteau
echo "<br>";
echo "<br>";
echo $electonic->getStock();
