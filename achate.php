<?php
include "navbar.php";

// Validate and sanitize the ID parameter
$category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$category_id) {
    die("Invalid category ID");
}

// Fetch products for the category with error handling
try {
    $stmt = $conn->prepare("SELECT * FROM produit WHERE id_categorie = ?");
    $stmt->execute([$category_id]);
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
    <title>Category Products | Modern Shop</title>
    
    <!-- Bootstrap CSS with integrity check -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f5f5;
            color: var(--dark-text);
        }
        
        .shop-layout {
            display: flex;
            min-height: calc(100vh - 56px);
        }
        
        .category-sidebar {
            flex: 0 0 280px;
            background: white;
            padding: 1.5rem;
            height: 100vh;
            position: sticky;
            top: 0;
            box-shadow: var(--shadow-sm);
            overflow-y: auto;
        }
        
        .sidebar-header {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--secondary-color);
        }
        
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .category-item {
            margin-bottom: 0.5rem;
            transition: var(--transition);
        }
        
        .category-link {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--dark-text);
            text-decoration: none;
            border-radius: 6px;
            transition: var(--transition);
        }
        
        .category-link:hover,
        .category-link:focus {
            background-color: var(--secondary-color);
            color: white;
            transform: translateX(5px);
        }
        
        .category-link.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .products-grid {
            flex: 1;
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 2rem;
        }
        
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: none;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        
        .product-img {
            width: 100%;
            height: 180px;
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
        
        .product-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            transition: var(--transition);
            width: 100%;
        }
        
        .product-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        @media (max-width: 992px) {
            .shop-layout {
                flex-direction: column;
            }
            
            .category-sidebar {
                width: 100%;
                height: auto;
                position: static;
            }
            
            .products-grid {
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
    
    <div class="shop-layout">
        <aside class="category-sidebar">
            <h2 class="sidebar-header">Categories</h2>
            <ul class="category-list">
                <?php foreach($categories as $category): ?>
                    <li class="category-item">
                        <a href="achate.php?id=<?= htmlspecialchars($category['id']) ?>" 
                           class="category-link <?= $category['id'] == $category_id ? 'active' : '' ?>">
                            <?= htmlspecialchars($category['libelle']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <main class="products-grid">
            <?php if (empty($products)): ?>
                <div class="col-12 text-center py-5">
                    <h3>No products found in this category</h3>
                    <p class="text-muted">Please check back later or browse other categories</p>
                </div>
            <?php else: ?>
                <?php foreach($products as $product): 
                    $finalPrice = !empty($product["discount"]) 
                        ? $product["prix"] - (($product["prix"] * $product["discount"]) / 100)
                        : $product["prix"];
                ?>
                    <article class="product-card">
                        <img src="front/<?= htmlspecialchars($product['image']) ?>" 
                             alt="<?= htmlspecialchars($product['libelle']) ?>" 
                             class="product-img">
                        
                        <div class="product-body">
                            <h3 class="product-title"><?= htmlspecialchars($product['libelle']) ?></h3>
                            
                            <div class="price-container">
                                <?php if($finalPrice < $product["prix"]): ?>
                                    <span class="current-price"><?= number_format($finalPrice, 2) ?> DH</span>
                                    <span class="original-price"><?= number_format($product["prix"], 2) ?> DH</span>
                                <?php else: ?>
                                    <span class="current-price"><?= number_format($finalPrice, 2) ?> DH</span>
                                <?php endif; ?>
                            </div>
                            
                            <a href="panier.php?id=<?= $product['id_produit'] ?>&lib=<?= urlencode($product['libelle']) ?>&prix=<?= $finalPrice ?>&img=<?= urlencode($product['image']) ?>&idd=<?= $product['id_categorie'] ?>&qte=<?= $product['qtestk']?>" 
                               class="product-btn">
                                View Details
                                <i class="bi bi-bag-plus-fill"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>