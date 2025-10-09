<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

require 'product.php';
require 'category.php';
require 'clothing.php';
require 'electronic.php';



$clothing=new Clothing();
var_dump($clothing->findOneById(88));
echo "<br>";
echo "<br>";
$electronic=new Electronic();
var_dump($electronic->findOneById(89));
echo "<br>";
echo "<br>";
var_dump($clothing->findAll());
echo "<br>";
echo "<br>";
var_dump($electronic->findAll());