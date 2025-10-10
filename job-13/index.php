<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Paris');

require 'product.php';
require 'category.php';
require 'clothing.php';
require 'electronic.php';



$clothing=new Clothing(null,'manteau',['https://picsum.photos/9000/3000'],220,'manteau enfant',2,4,new DateTime(),new DateTime(),'S','vert','coton',222);
echo $clothing->getName();//on recupère le nom
echo "<br>";
print_r( $clothing->getPhotos());//on recupère le nom

echo "<br>";
$electronic=new Electronic (null,'PS2',['https://picsum.photos/98/300'],1000,"console",2,4,new DateTime(),new DateTime(),'Sony',22);
echo $electronic->getName();//on recupère le nom
echo "<br>";
print_r( $electronic->getPhotos());//on recupère le nom