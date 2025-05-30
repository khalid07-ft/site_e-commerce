<?php

include "navbar.php";
$id = $_POST["id"] ?? null;
$qt = $_POST["qt"] ?? null;
$qte=$_GET["qte"] ?? null;

if ($qte !== null && $qt !== null) {
    if ($qt > $qte) {
        echo '<script>alert("La quantité demandée dépasse la quantité en stock.");</script>';
        echo '<script>window.location.href = "afficher_panier.php";</script>';
        exit;
    }
    $new_qte = $qte - $qt;
    $stmt = $conn->prepare("UPDATE produit SET qtestk=? WHERE id_produit = ?");
    $stmt->execute([$new_qte, $id]);
}

if(!isset($_SESSION["panier"]["utilisateur"]['id_utilisateur'])) {
    $_SESSION["panier"]["utilisateur"]['id_utilisateur'] = [];
} elseif(isset($id)) {
    unset($_SESSION["panier"]["utilisateur"]['id_utilisateur'][$id]);
}
if($qt>0){
    $_SESSION["panier"]["utilisateur"]['id_utilisateur'][$id]=$qt;
    echo '<script>window.location.href = "afficher_panier.php";</script>';
}
$productIds = array_keys($_SESSION["panier"]["utilisateur"]['id_utilisateur']);
if (empty($productIds)) {
    echo '<div class="container my-5">
            <div class="empty-cart text-center py-5">
                <i class="fas fa-shopping-cart fa-4x mb-4 text-muted"></i>
                <h3 class="mb-3">Votre panier est vide</h3>
                <p class="text-muted mb-4">Commencez votre shopping pour découvrir nos produits</p>
                <a href="index.php" class="btn btn-primary px-4">
                    <i class="fas fa-store me-2"></i>Boutique
                </a>
            </div>
          </div>';
    exit;
}
$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$stmt = $conn->prepare("SELECT * FROM produit WHERE id_produit IN ($placeholders)");
$stmt->execute($productIds);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier | <?= $siteName ?? 'MonShop' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --second-color:rgb(35, 207, 61);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        
        .cart-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .cart-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 20px;
        }
        
        .product-card {
            transition: all 0.3s ease;
            border-bottom: 1px solid #eee;
        }
        
        .product-card:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .quantity-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 5px;
        }
        
        .summary-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .btn-checkout {
            background: var(--primary-color);
            border: none;
            padding: 10px;
            font-weight: 600;
        }
        
        .btn-success {
            background: var(--primary-color);
            border: none;
            padding: 10px;
            font-weight: 600;
        }
        .btn-checkout:hover {
            background: var(--accent-color);
        }
        .btn-success:hover {
            background: var(--second-color);
        }
        .discount-badge {
            background: var(--accent-color);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="cart-container">
            <div class="cart-header">
                <h2 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Votre Panier</h2>
            </div>
            
            <div class="p-4">
                <?php $total = 0; ?>
                <?php foreach($products as $product): 
             
                    $productId = $product["id_produit"];
                    $quantity = $_SESSION["panier"]["utilisateur"]['id_utilisateur'][$productId] ?? 1;
                    $price = $product["prix"] * (1 - ($product["discount"]/100));
                    $productTotal = $price * $quantity;
                    $total += $productTotal;
                ?>
                <div class="product-card d-flex align-items-center p-3">
                    <div class="flex-shrink-0">
                        <img src="front/<?= $product['image'] ?? 'default.jpg' ?>" 
                             class="product-img" 
                             alt="<?= $product['libelle']?>">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1"><?= $product['libelle']?></h5>
                        <small class="text-muted">Réf: <?= $productId ?></small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold mb-1">
                            <?= number_format($price, 2) ?> DH
                            <?php if($product["discount"] > 0): ?>
                                <span class="discount-badge ms-2">-<?= $product["discount"] ?>%</span>
                            <?php endif; ?>
                        </div>
                        <div class="quantity-selector d-flex align-items-center">
                            <button class="quantity-btn minus">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="quantity-input" value="<?= $quantity ?>" min="1" disabled>
                            <button class="quantity-btn plus">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="ms-4 text-end" style="width: 100px;">
    <div class="fw-bold"><?= number_format($productTotal, 2) ?> DH</div>
    <form method="post" action="afficher_panier.php" class="mt-2">
        <input type="hidden" name="id" value="<?= $product['id_produit'] ?>">
        <input type="hidden" name="quantity_in_cart" value="<?= $quantity ?>">
        <button type="submit" class="btn btn-danger btn-sm" name="supprimer">
            <i class="fas fa-trash"></i> Supprimer
        </button>
    </form>
    <?php 
if (isset($_POST['supprimer'])) {
    unset($_SESSION['panier']['utilisateur']['id_utilisateur'][$product_id]);
}

?>
</div>
                </div>
                <?php endforeach; ?>
                <div class="text-end mt-4 p-3 bg-light rounded">
                    <h4 class="mb-0">
                        Total: <span class="text-primary"><?= number_format($total, 2) ?> DH</span>
                    </h4>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-chevron-left me-2"></i>Continuer mes achats
                    </a>
                    <?php
                    if(isset($_POST["vider"])){
                        unset($_SESSION["panier"]["utilisateur"]['id_utilisateur']);
                        $_SESSION["panier"]["utilisateur"]['id_utilisateur']=[];
                        echo '<script>window.location.href="afficher_panier.php"</script>';
            
                    }
                    ?>
                    <form method="post" action="afficher_panier.php">
                        <input type="hidden" name="id" value="<?= $productId ?>">
                        <input type="hidden" name="qt" value="<?= $quantity ?>">
                    <input  type="submit" value="Passer la commande" class="btn btn-success text-light" name="commander">
                    <?php if(isset($_POST["commander"])) {
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    $stmt = $conn->prepare("SELECT * FROM produit WHERE id_produit IN ($placeholders)");
    $stmt->execute($productIds);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($products as $product) {
        $productId = $product["id_produit"];
        $quantity = $_SESSION["panier"]["utilisateur"]['id_utilisateur'][$productId];
        $stmt = $conn->prepare("INSERT INTO panier (id_utilisateur, quantite, id_produit) VALUES (?, ?, ?)");
        if($_SESSION['id_utilisateur']){$stmt->execute([$_SESSION['id_utilisateur'], $quantity, $productId]);}
        else{
            echo '<script>alert("Veuillez vous connecter pour passer la commande.");</script>';
        }
    }
    unset($_SESSION["panier"]["utilisateur"]['id_utilisateur']);
    

}
?>
                </form>
                    <form method="post" action="afficher_panier.php" >
                    <input onclick="return confirm('vous voulez vraiment vider votre panier ! ')" type="submit" value="vider la commande"  class="btn btn-checkout text-light" name="vider">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentNode.querySelector('.quantity-input');
                let value = parseInt(input.value);
                
                if (this.classList.contains('minus')) {
                    input.value = value > 1 ? value - 1 : 1;
                } else {
                    input.value = value + 1;
                }
            });
        });
    </script>
</body>
</html>