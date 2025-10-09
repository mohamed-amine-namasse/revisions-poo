<?php
class Product
{
        private int $id = 58;
        private string $name;
        private array $photos;
        private int  $price;
        private string $description;
        private int $quantity;
        private int $category_id;
        private DateTime $createdAt;
        private DateTime $updatedAt;
        private string $db_server = "localhost:3306";
        private string $db_user = "root";
        private string $db_password = "";
        private string $db_name = "draft-shop";
        

        // Constructeur
        public function __construct( int|null $id = 0, string $name = "", array $photos = [], int $price = 0, string $description = "", int $quantity = 0,int $category_id = 0, DateTime $createdAt = new DateTime(),DateTime $updatedAt = new DateTime() )
        {   if($id==null){
                $id=-1;
                $this->id=$id;
            }
            
            $this->id = $id;
            $this->name = $name;
            $this->photos = $photos;
            $this->price = $price;
            $this->description = $description;
            $this->quantity = $quantity;
            $this->category_id = $category_id;
            $this->createdAt = $createdAt ;
            $this->updatedAt = $updatedAt ;
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
        // Connexion à la BDD
        public function connect(int $id): bool
        {
            $conn = $this->getConnection();

            // Selectionne le produit et donne aux attributs de la classe les valeurs correspondantes
            $stmt = $conn->prepare("SELECT * FROM product WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if (!$product) {
                return false; // produit non trouvé
            }
            $stmt = $conn->prepare("SELECT filepath FROM photos WHERE product_id = :id ");
            $stmt->execute([':id' => $id]);
            $product_photo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($product_photo);
            
                
            
            if (!$product_photo) {
                return false; // produit non trouvé
            }
            
                $this->id = $product['id'];
                $this->name = $product['name'];
                foreach($product_photo as $item){$this->photos[]=$item['filepath'];}
                $this->price = $product['price'];
                $this->description = $product['description'];
                $this->quantity = $product['quantity'];
                $this->category_id = $product['category_id'];
                $this->createdAt = new DateTime ($product['created_at']);
                $this->updatedAt = new DateTime ($product['updated_at']) ;
                return true;
            

            
        }
        // Getters et Setters
        public function getId(): int
        {
            return $this->id;
        }

        public function setId(int $id): void
        {
            $this->id = $id;
        }

        public function getName(): string
        {
            return $this->name;
        }

        public function setName(string $name): void
        {
            $this->name = $name;
        }

        public function getPhotos(): array
        {
            return $this->photos;
        }

        public function setPhotos(array $photos): void
        {
            $this->photos = $photos;
        }

        public function getPrice(): int
        {
            return $this->price;
        }

        public function setPrice(int $price): void
        {
            $this->price = $price;
        }

        public function getDescription(): string
        {
            return $this->description;
        }

        public function setDescription(string $description): void
        {
            $this->description = $description;
        }

        public function getQuantity(): int
        {
            return $this->quantity;
        }

        public function setQuantity(int $quantity): void
        {
            $this->quantity = $quantity;
        }
        public function getCategoryId(): int
        {
            return $this->category_id;
        }
        public function setCategoryId(int $category_id): void
        {
            $this->category_id = $category_id;
        }

        // La fonction getCategory
        public function getCategory(): ?Category
    {
        try {
            $conn = $this->getConnection();

            $stmt = $conn->prepare("SELECT * FROM category WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $this->category_id]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$category) {
                return null; // Aucun résultat trouvé
            }

            // Création de l'objet Category
            return new Category(
                $category['id'],
                $category['name'],
                $category['description'],
                new DateTime($category['created_at']),
                new DateTime($category['updated_at'])
            );
        } catch (Exception $e) {
            // Gérer proprement les erreurs (log ou affichage selon le besoin)
            echo "Erreur lors de la récupération de la catégorie : " . $e->getMessage();
            return null;
        }
    }

        
        public function getCreatedAt(): DateTime
        {
            return $this->createdAt;
            
        }

        public function setCreatedAt(DateTime $createdAt): void
        {
            $this->createdAt = $createdAt;
        
        }

        public function getUpdatedAt(): DateTime
        {
            return $this->updatedAt;
        }

        public function setUpdatedAt(DateTime $updatedAt): void
        {
            $this->updatedAt = $updatedAt;
        }
        // Accesseurs
        public function getAllInfos(): array
        {
            return [
                
            'id'=> $this->id ,
            'name'=>$this->name,
            'photos'=> $this->photos,
            'price'=> $this->price,
            'description'=> $this->description,
            'quantity'=> $this->quantity,
            'category_id'=>$this-> category_id,
            'createdAt'=> $this->createdAt,
            'updatedAt'=> $this-> updatedAt
            ];
        }
        public function findOneById(int $id):Product|bool
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

            // Création de l'objet product
            return new Product(
                $product['id'],
                $product['name'],
                $photos,
                $product['price'],
                $product['description'],
                $product['quantity'],
                $product['category_id'],
                new DateTime($product['created_at']),
                new DateTime($product['updated_at'])
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

            // 3. Retourner l'objet courant avec son ID
            return $this;

        } catch (Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }
 
}