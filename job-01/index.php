<?php
include "product.php";
$obj=new Product(34,'T-shirt',['https://picsum.photos/200/300'],5000,'A nice T-shirt',10,new DateTime(), new DateTime()); // on crée une instance d'un produit
var_dump($obj);
echo "<br>";
echo "<br>";
echo $obj->getId();//on recupère l'id
echo "<br>";
echo $obj->setId(90);//on modifie l'id
echo "<br>";
echo $obj->getId();//on recupère l'id
echo "<br>";
echo "<br>";
echo $obj->getName();//on recupère le nom
echo "<br>";
echo $obj->setName("Portable");//on modifie le nom
echo "<br>";
echo $obj->getName();//on recupère le nom
echo "<br>";
echo "<br>";
print_r( $obj->getPhotos());//on recupère url de la photo
echo "<br>";
print_r( $obj->setPhotos(['https://picsum.photos/210/500']));//on modifie url de la photo
echo "<br>";
print_r($obj->getPhotos());//on recupère url de la photo
echo "<br>";
echo "<br>";
echo $obj->getPrice();//on recupère le prix
echo "<br>";
echo $obj->setPrice(1000);//on modifie le prix
echo "<br>";
echo $obj->getPrice();//on recupère le prix
echo "<br>";
echo "<br>";
echo $obj->getDescription();//on recupère la description
echo "<br>";
echo $obj->setDescription("fff");//on modifie la description
echo "<br>";
echo $obj->getDescription();//on recupère la description
echo "<br>";
echo "<br>";
echo $obj->getQuantity();//on recupère la quantité
echo "<br>";
echo $obj->setQuantity(8);//on modifie la quantité
echo "<br>";
echo $obj->getQuantity();//on recupère la quantité
echo "<br>";
echo "<br>";
echo "la date de création par defaut:"." ";
echo $obj->getCreatedAt()->format('Y-m-d H:i:s');//on recupère date de création
echo "<br>";
$obj->setCreatedAt(new DateTime("2025-08-15 11:45:02"));//on modifie la date de création
echo "la nouvelle valeur:"." ";
echo $obj->getCreatedAt()->format('Y-m-d H:i:s');//on recupère la date de création
echo "<br>";
echo "la date de mise à jour par defaut:"." ";
echo $obj->getUpdatedAt()->format('Y-m-d H:i:s');//on recupère la date de mise à jour
echo "<br>";
$obj->setUpdatedAt(new DateTime("2025-08-15 11:55:02"));//on modifie la date de mise à jour
echo "la nouvelle valeur:"." ";
echo $obj->getUpdatedAt()->format('Y-m-d H:i:s');//on recupère la date de mise à jour

