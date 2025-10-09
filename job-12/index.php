<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

require 'product.php';
require 'category.php';
require 'clothing.php';
require 'electronic.php';



//$clothing=new Clothing();
//var_dump($clothing->findOneById(88));
echo "<br>";
echo "<br>";
//$electronic=new Electronic();
//var_dump($electronic->findOneById(89));
echo "<br>";
echo "<br>";
//var_dump($clothing->findAll());
echo "<br>";
echo "<br>";
//var_dump($electronic->findAll());

//$clothing=new Clothing(null,'pyjama',['https://picsum.photos/9000/3000'],220,'pyjama enfant',2,4,new DateTime(),new DateTime(),'S','vert','coton',222);
//var_dump($clothing->create());
echo "<br>";
echo "<br>";
$electronic=new Electronic (null,'PS2',['https://picsum.photos/98/300'],1000,"console",2,4,new DateTime(),new DateTime(),'Sony',22);
var_dump($electronic->create());
echo "<br>";
echo "<br>";



//$clothing=new Clothing(null,'Pull',['https://picsum.photos/500/3000'],220,'pull enfant',2,4,new DateTime(),new DateTime(),'S','marron','coton',222);
//var_dump($clothing);
echo "<br>";
echo "<br>";
//$clothing->create(); 
//var_dump($clothing);
echo "<br>";
echo "<br>";
//$clothing->setName('Veste');
//$clothing->setQuantity(23);
//var_dump($clothing);
echo "<br>";
//$clothing->update();
