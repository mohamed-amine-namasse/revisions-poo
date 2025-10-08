<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

require 'product.php';
require 'category.php';
require 'clothing.php';
require 'electronic.php';



$clothing=new Clothing();
var_dump($clothing->findOneById(88));

