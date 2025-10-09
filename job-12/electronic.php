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
    public function __construct(int|null $id = 0, string $name = "", array $photos = [], int $price = 0, string $description = "", int $quantity = 0,int $category_id = 0, DateTime $createdAt = new DateTime(),DateTime $updatedAt = new DateTime(),string $brand="",int $warranty_fee=0)
    {
        parent::__construct($id,$name,$photos,$price,$description,$quantity,$category_id,$createdAt,$updatedAt);
        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
        
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
    public function findOneById(int $id):Electronic|bool
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
            // 3. Requête infos de electronic
            $electonicStmt = $conn->prepare("SELECT * FROM electronic WHERE product_id = :id");
            $electonicStmt->execute([':id' => $id]);
            $electronic = $electonicStmt->fetch(PDO::FETCH_ASSOC);  

            // Création de l'objet product
            return new Electronic(
                $product['id'],
                $product['name'],
                $photos,
                $product['price'],
                $product['description'],
                $product['quantity'],
                $product['category_id'],
                new DateTime($product['created_at']),
                new DateTime($product['updated_at']),
                $electronic['brand'],
                $electronic['warranty_fee']
              
            );
        
            
        
        } 
        
        catch (Exception $e) {
            
            echo "Erreur lors de la récupération du produit : " . $e->getMessage();
            return false;
        }
    

        
    }

    public function findAll():array
    {   
        $electronics = [];
        try {
            $conn = $this->getConnection();

            // Requête pour recuperer tous les données des clothings
            $stmt = $conn->prepare("SELECT 
                p.id,
                p.name,
                p.price,
                p.description,
                p.quantity,
                p.category_id,
                p.created_at,
                p.updated_at,
                e.brand,
                e.warranty_fee
            FROM product p
            INNER JOIN electronic e ON p.id = e.product_id ");
            $stmt->execute();
            $productRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($productRows as $row) {
            // Requête photos du produit
            $photoStmt = $conn->prepare("SELECT filepath FROM photos WHERE product_id = :id ");
            $photoStmt->execute([':id' => $row['id']]);
            $photoData = $photoStmt->fetchAll(PDO::FETCH_ASSOC);

            $photos = [];
            foreach ($photoData as $photo) {
                $photos[] = $photo['filepath'];
            }
            // Créer une instance Product
                $electronic = new Electronic(
                    $row['id'],
                    $row['name'],
                    $photos,
                    $row['price'],
                    $row['description'],
                    $row['quantity'],
                    $row['category_id'],
                    new DateTime($row['created_at']),
                    new DateTime($row['updated_at']),
                    $row['brand'],
                    $row['warranty_fee'] 
                );
            $electronics[] = $electronic;
            } }
        
        catch (Exception $e) {
            
            echo "Erreur lors de la récupération du produit : " . $e->getMessage();
            
        }
        return $electronics;

        
    }

      public function create(): Electronic|false
    {
        try {
            $conn = $this->getConnection();

           
             // 1. Insertion des infos dans la table "product"
            $stmt = $conn->prepare("
               INSERT INTO product (name, price, description, quantity, category_id, created_at, updated_at)
                VALUES (:name, :price, :description, :quantity, :category_id, :created_at, :updated_at)
            ");

            $success = $stmt->execute([
                ':name' => $this->getName(),
                ':price' => $this->getPrice(),
                ':description' => $this->getDescription(),
                ':quantity' => $this->getQuantity(),
                ':category_id' => $this->getCategoryId(),
                ':created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
                ':updated_at' => $this->getUpdatedAt()->format('Y-m-d H:i:s')
               
            ]);

            if (!$success) {
                return false;
            }
             // 2. Insertion des infos dans la table "electronic"
            $stmt = $conn->prepare("
                INSERT INTO electronic (brand, warranty_fee,product_id)
                VALUES (:brand, :warranty_fee,:product_id)
            ");
           // Récupérer l'ID généré automatiquement
            $this->setId($conn->lastInsertId());
            $success = $stmt->execute([
                ':brand' => $this->brand,
                ':warranty_fee' => $this->warranty_fee,
                ':product_id' => $this->getId()
               
            ]);

            if (!$success) {
                return false;
            }
           
            // 3. Insérer les photos si présentes
            if (!empty($this->getPhotos())) {
                $photoStmt = $conn->prepare("
                    INSERT INTO photos (filepath,product_id)
                    VALUES ( :filepath,:product_id)
                ");
                
                foreach ($this->getPhotos() as $filepath) {
                    $photoStmt->execute([
                        
                        ':product_id' => $this->getId(),
                        ':filepath' => $filepath
                    ]);
                }
            }

            // 4. Retourner l'objet courant avec son ID
            return $this;
        
            

        } catch (Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }
    public function update(): Electronic|false
    {
        try {
            $conn = $this->getConnection();

            // 1. mise à jour du produit dans la table "product"
            $stmt = $conn->prepare(" UPDATE product SET name=:name,price=:price,description=:description,quantity=:quantity,category_id=:category_id,created_at=:created_at,updated_at=:updated_at WHERE id = :id ");
            $success = $stmt->execute([
                ':id'=>$this->$this->getId(),
                ':name' => $this->getName(),
                ':price' => $this->getPrice(),
                ':description' => $this->getDescription(),
                ':quantity' => $this->getQuantity(),
                ':category_id' => $this->getCategoryId(),
                ':created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
                ':updated_at' => $this->getUpdatedAt()->format('Y-m-d H:i:s')
            ]);

            if (!$success) {
                return false;
            }

            
            
            // 2.Mise à jour des photos 
            if (!empty($this->photos)) {
                $photoStmt = $conn->prepare("
                    UPDATE  photos SET filepath=:filepath WHERE product_id=:product_id
                ");

                foreach ($this->getPhotos() as $filepath) {
                    $photoStmt->execute([
                        ':product_id' => $this->getId(),
                        ':filepath' => $filepath
                        
                    ]);
                }
            }
            //3. Mise à jour dans la table electronic
            $stmt = $conn->prepare(" UPDATE electronic SET brand=:brand,warranty_fee=:warranty_fee WHERE id = :id ");
            $success = $stmt->execute([
                ':size'=>$this->size,
                ':color' => $this->color,
                ':type' => $this->type,
                ':material_fee' => $this->material_fee,
                
            ]);
            // 4. Retourner l'objet courant avec son ID
            return $this;

        } catch (Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }
    

}