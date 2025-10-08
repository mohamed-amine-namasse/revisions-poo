<?php
class Electronic extends Product
{
   
    private string $brand;
    private int $warranty_fee;

    private string $db_server = "localhost:3306";
    private string $db_user = "root";
    private string $db_password = "";
    private string $db_name = "draft-shop";
    
    

    // Constructeur
    public function __construct(string $brand,int $warranty_fee)
    {
        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
        
    }
}