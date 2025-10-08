<?php
class Clothing extends Product
{
   
    private string $size;
    private string $color;
    private string $type;
    private int $material_fee;

    private string $db_server = "localhost:3306";
    private string $db_user = "root";
    private string $db_password = "";
    private string $db_name = "draft-shop";
    
    

    // Constructeur
    public function __construct(string $size,string $color,int $material_fee)
    {
       
        $this->size = $size;
        $this->color = $color;
        $this->material_fee = $material_fee;
        
    }
}