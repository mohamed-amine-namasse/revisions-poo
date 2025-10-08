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
        $products = [];
        try {
            $conn = $this->getConnection();

            // 1. Requête pour recuperer tous les données des produits
            $stmt = $conn->prepare("SELECT * FROM product ");
            $stmt->execute();
            $productRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($productRows as $row) {
            // 2. Requête photos du produit
            $photoStmt = $conn->prepare("SELECT filepath FROM photos WHERE product_id = :id ");
            $photoStmt->execute([':id' => $row['id']]);
            $photoData = $photoStmt->fetchAll(PDO::FETCH_ASSOC);

            $photos = [];
            foreach ($photoData as $photo) {
                $photos[] = $photo['filepath'];
            }
            // Créer une instance Product
                $product = new Product(
                    $row['id'],
                    $row['name'],
                    $photos,
                    $row['price'],
                    $row['description'],
                    $row['quantity'],
                    $row['category_id'],
                    new DateTime($row['created_at']),
                    new DateTime($row['updated_at'])
                );
            $products[] = $product;
            } }
        
        catch (Exception $e) {
            
            echo "Erreur lors de la récupération du produit : " . $e->getMessage();
            
        }
        return $products;

        
    }

     public function create(): Product|false
    {
        try {
            $conn = $this->getConnection();

            // 1. Insertion du produit dans la table "product"
            $stmt = $conn->prepare("
                INSERT INTO product (name, price, description, quantity, category_id, created_at, updated_at)
                VALUES (:name, :price, :description, :quantity, :category_id, :created_at, :updated_at)
            ");

            $success = $stmt->execute([
                ':name' => $this->name,
                ':price' => $this->price,
                ':description' => $this->description,
                ':quantity' => $this->quantity,
                ':category_id' => $this->category_id,
                ':created_at' => $this->createdAt->format('Y-m-d H:i:s'),
                ':updated_at' => $this->updatedAt->format('Y-m-d H:i:s')
            ]);

            if (!$success) {
                return false;
            }

            // 2. Récupérer l'ID généré automatiquement
            $this->id = (int)$conn->lastInsertId();

            // 3. Insérer les photos si présentes
            if (!empty($this->photos)) {
                $photoStmt = $conn->prepare("
                    INSERT INTO photos (filepath,product_id)
                    VALUES ( :filepath,:product_id)
                ");

                foreach ($this->photos as $filepath) {
                    $photoStmt->execute([
                        
                        ':product_id' => $this->id,
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
    public function update(): Product|false
    {
        try {
            $conn = $this->getConnection();

            // 1. mise à jour du produit dans la table "product"
            $stmt = $conn->prepare(" UPDATE product SET name=:name,price=:price,description=:description,quantity=:quantity,category_id=:category_id,created_at=:created_at,updated_at=:updated_at WHERE id = :id ");
            $success = $stmt->execute([
                ':id'=>$this->id,
                ':name' => $this->name,
                ':price' => $this->price,
                ':description' => $this->description,
                ':quantity' => $this->quantity,
                ':category_id' => $this->category_id,
                ':created_at' => $this->createdAt->format('Y-m-d H:i:s'),
                ':updated_at' => $this->updatedAt->format('Y-m-d H:i:s')
            ]);

            if (!$success) {
                return false;
            }

            
            
            // 2.Mise à jour des photos 
            if (!empty($this->photos)) {
                $photoStmt = $conn->prepare("
                    UPDATE  photos SET filepath=:filepath WHERE product_id=:product_id
                ");

                foreach ($this->photos as $filepath) {
                    $photoStmt->execute([
                        ':product_id' => $this->id,
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
    

}

