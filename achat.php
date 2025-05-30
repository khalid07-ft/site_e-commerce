
<?php
include "navbar.php";
try {
    $stmt = $conn->prepare("SELECT * FROM produit");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Our Products</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-gray);
            background-color: #f5f5f5;
        }
        
        .shop-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            flex: 0 0 250px;
            background-color: white;
            padding: 1.5rem;
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            box-shadow: var(--shadow);
        }
        
        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--secondary-color);
        }
        
        .category-list {
            list-style: none;
            padding: 0;
        }
        
        .category-item {
            margin-bottom: 0.5rem;
            transition: var(--transition);
        }
        
        .category-link {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--dark-gray);
            text-decoration: none;
            border-radius: 4px;
            transition: var(--transition);
        }
        
        .category-link:hover, 
        .category-link:focus {
            background-color: var(--secondary-color);
            color: white;
            transform: translateX(5px);
        }
        
        .products-container {
            flex: 1;
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .product-body {
            padding: 1.25rem;
        }
        
        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--primary-color);
        }
        
        .price-container {
            margin-bottom: 1rem;
        }
        
        .current-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent-color);
        }
        
        .original-price {
            font-size: 0.9rem;
            color: #6c757d;
            text-decoration: line-through;
            margin-left: 0.5rem;
        }
        
        .product-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: var(--transition);
            width: 100%;
        }
        
        .product-button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .shop-container {
                flex-direction: column;
            }
            
            .sidebar {
                height: auto;
                position: static;
                width: 100%;
            }
            
            .products-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    try {
        $stmt = $conn->prepare("SELECT * FROM categorie");
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
    ?>
    
    <div class="shop-container">
        <aside class="sidebar">
            <h2 class="sidebar-title">Categories</h2>
            <ul class="category-list">
                <?php foreach($categories as $category): ?>
                    <li class="category-item">
                        <a href="achate.php?id=<?= $category['id'] ?>" class="category-link">
                            <?= $category['libelle'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <main class="products-container">
            <?php foreach($products as $product): 
                $finalPrice = !empty($product["discount"]) 
                    ? $product["prix"] - (($product["prix"] * $product["discount"]) / 100)
                    : $product["prix"];
            ?>
                <article class="product-card">
                    <img src="front/<?= $product['image'] ?>" alt="<?= $product['libelle'] ?>" class="product-image">
                    
                    <div class="product-body">
                        <h3 class="product-title"><?= $product['libelle'] ?></h3>
                        
                        <div class="price-container">
                            <?php if($finalPrice < $product["prix"]): ?>
                                <span class="current-price"><?= number_format($finalPrice, 2) ?> DH</span>
                                <span class="original-price"><?= number_format($product["prix"], 2) ?> DH</span>
                            <?php else: ?>
                                <span class="current-price"><?= number_format($finalPrice, 2) ?> DH</span>
                            <?php endif; ?>
                        </div>
                        
                        <a href="panier.php?id=<?= $product['id_produit'] ?>&lib=<?= urlencode($product['libelle']) ?>&prix=<?= $finalPrice ?>&img=<?= urlencode($product['image']) ?>&idd=<?= $product['id_categorie'] ?>&qte=<?= $product['qtestk'] ?>" 
                           class="product-button">
                            View Details
                            <i class="bi bi-bag-plus-fill"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>