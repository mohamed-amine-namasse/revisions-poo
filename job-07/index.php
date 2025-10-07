<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Paris');
class Category
{
    private int $id = 58;
    private string $name;
    private string $description;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private string $db_server = "localhost:3306";
    private string $db_user = "root";
    private string $db_password = "";
    private string $db_name = "draft-shop";
    
    

    // Constructeur
    public function __construct(int $id,string $name,string $description,DateTime $createdAt=new DateTime(),DateTime $updatedAt=new DateTime())
    {
    $this->id = $id;
    $this->name = $name;
    $this->description = $description;
    $this->createdAt = $createdAt;
    $this->updatedAt = $updatedAt;
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


    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
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
    public function getProducts(): array
{
    $products = [];

    try {
        $conn = $this->getConnection();

        $stmt = $conn->prepare("SELECT * FROM product WHERE category_id = :category_id");
        $stmt->execute([':category_id' => $this->id]);
        $productDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($productDataList as $data) {
            //  Récupérer les photos du produit
            $photoStmt = $conn->prepare("SELECT filepath FROM photos WHERE product_id = :product_id");
            $photoStmt->execute([':product_id' => $data['id']]);
            $photoRows = $photoStmt->fetchAll(PDO::FETCH_ASSOC);
            $photos = [];
            foreach ($photoRows as $photo) {
                $photos[] = $photo['filepath'];
            }
            $product = new Product(
                $data['id'],
                $data['name'],
                $photos,
                $data['price'],
                $data['description'],
                $data['quantity'],
                $data['category_id'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at'])
            );

            $products[] = $product;
        }
    } catch (Exception $e) {
        // Affiche ou logue l’erreur si besoin
        echo "Erreur lors de la récupération des produits : " . $e->getMessage();
    }

    return $products;
    }

}

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
    public function __construct( int $id = 0, string $name = "", array $photos = [], int $price = 0, string $description = "", int $quantity = 0,int $category_id = 0, DateTime $createdAt = new DateTime(),DateTime $updatedAt = new DateTime() )
    {
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
    public function findOneById(int $id):bool
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

        // 3. On attribue à l’objet courant ($this)
        $this->id = $product['id'];
        $this->name = $product['name'];
        $this->photos = $photos;
        $this->price = $product['price'];
        $this->description = $product['description'];
        $this->quantity = $product['quantity'];
        $this->category_id = $product['category_id'];
        $this->createdAt = new DateTime($product['created_at']);
        $this->updatedAt = new DateTime($product['updated_at']);
        
      
        return true;
    } 
    
    catch (Exception $e) {
        
        echo "Erreur lors de la récupération du produit : " . $e->getMessage();
        return false;
    }
   

    
 }
}
//Partie test

$product = new Product();
$product->findOneById(7);
print_r($product->getAllInfos());
