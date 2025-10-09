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
    public function __construct(int|null $id = 0, string $name = "", array $photos = [], int $price = 0, string $description = "", int $quantity = 0,int $category_id = 0, DateTime $createdAt = new DateTime(),DateTime $updatedAt = new DateTime(),string $size="",string $color="",int $material_fee=0)
    {
        parent::__construct($id,$name,$photos,$price,$description,$quantity,$category_id,$createdAt,$updatedAt);
        $this->size = $size;
        $this->color = $color;
        $this->material_fee = $material_fee;
        
    }
    // Méthode privée pour obtenir une connexion PDO
        private function getConnection(): PDO
        {
            try {
            $pdo = new PDO("mysql:host=$this->db_server;dbname=$this->db_name;", $this->db_user, $this->db_password);
            // Active le mode exception pour les erreurs SQL
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo; }   
            catch (PDOException $e) {
            die("Erreur de connexion PDO : " . $e->getMessage());
            }
        }
     // Getters et Setters
    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color= $color;
    }


    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function findOneById(int $id):Clothing|bool
    {   

        try {
            $conn = $this->getConnection();

            // 1. Requête produit
            $stmt = $conn->prepare("SELECT * FROM product WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                return false; // Produit non trouvé
            }
            
            // 2. Requête photos du produit
            $photoStmt = $conn->prepare("SELECT filepath FROM photos WHERE product_id = :id");
            $photoStmt->execute([':id' => $id]);
            $photoData = $photoStmt->fetchAll(PDO::FETCH_ASSOC);

            $photos = [];
            foreach ($photoData as $photo) {
                $photos[] = $photo['filepath'];
            }
            // 3. Requête infos du clothing
            $clothingStmt = $conn->prepare("SELECT * FROM clothing WHERE product_id = :id");
            $clothingStmt->execute([':id' => $id]);
            $clothing = $clothingStmt->fetch(PDO::FETCH_ASSOC);

           


            // Création de l'objet clothing
            return new Clothing(
                $product['id'],
                $product['name'],
                $photos,
                $product['price'],
                $product['description'],
                $product['quantity'],
                $product['category_id'],
                new DateTime($product['created_at']),
                new DateTime($product['updated_at']),
                $clothing['size'],
                $clothing['color'],
                $clothing['material_fee']
            );
        
            
        
        } 
        
        catch (Exception $e) {
            
            echo "Erreur lors de la récupération du produit : " . $e->getMessage();
            return false;
        }
    

        
    }

    public function findAll():array
    {   
        $clothings = [];
        try {
        $conn = $this->getConnection();

        // 1. Requête pour recuperer tous les données des clothings
        $stmt = $conn->prepare("SELECT 
            p.id ,
            p.name ,
            p.price,
            p.description,
            p.quantity,
            p.category_id,
            p.created_at,
            p.updated_at,
            c.size,
            c.color,
            c.type,
            c.material_fee
        FROM product p
        INNER JOIN clothing c ON p.id = c.product_id ");
        $stmt->execute();
        $productRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //print_r($productRows);
        foreach ($productRows as $row) {
        // 3. Requête photos du produit
        $photoStmt = $conn->prepare("SELECT filepath FROM photos WHERE product_id = :id ");
        $photoStmt->execute([':id' => $row['id']]);
        $photoData = $photoStmt->fetchAll(PDO::FETCH_ASSOC);

        $photos = [];
        foreach ($photoData as $photo) {
            $photos[] = $photo['filepath'];
        }
        
      var_dump($row['material_fee']);
       
        // Créer une instance clothing
            $clothing = new Clothing(
                $row['id'],
                $row['name'],
                $photos,
                $row['price'],
                $row['description'],
                $row['quantity'],
                $row['category_id'],
                new DateTime($row['created_at']),
                new DateTime($row['updated_at']),
                $row['size'],
                $row['color'],
                $row['type'],
               (int) $row['material_fee']
            );
        $clothings[] = $clothing;
        } }
    
    catch (Exception $e) {
        
        echo "Erreur lors de la récupération du produit : " . $e->getMessage();
        
    }
    return $clothings;

    
 }
        
    }

    
    



