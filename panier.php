<?php
include "navbar.php";
$id = $_GET["id"];
$idd = $_GET["idd"];
$prix = $_GET["prix"];
$lib = $_GET["lib"];
$image = $_GET["img"];
$qte = $_GET["qte"];

$stmt = $conn->prepare("SELECT * FROM produit WHERE id_categorie = ?");
$stmt->execute([$id]);
$s = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $conn->prepare("SELECT * FROM categorie");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($lib) ?> | Détails du produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .product-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(0,0,0,0.1);
        }
        .product-image {
            width: 100%;
            height: auto;
            object-fit: contain;
            max-height: 500px;
            padding: 20px;
        }
        .product-details {
            padding: 30px;
        }
        .product-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 15px;
        }
        .product-price {
            font-size: 1.8rem;
            color: #e74c3c;
            font-weight: 700;
            margin: 15px 0;
        }
        .btn-custom {
            background-color: rgb(63, 185, 41);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.5s;
            border: none;
        }
        .btn-custom:hover {
            background-color: rgb(18, 92, 5);
            transform: translateY(-2px);
            color: white;
        }
        .quantity-selector {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f8f9fa;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 5px;
        }
        .product-description {
            margin: 30px 0;
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <div class="container py-2">
        <div class="row product-container">
            <div class="col-md-6">
                <img src="front/<?= htmlspecialchars($image) ?>" class="product-image">
            </div>
            <div class="col-md-6 product-details">
                <h1 class="product-title"><?= htmlspecialchars($lib) ?></h1>
                <span class="product-price"><?= htmlspecialchars($prix) ?> DH</span>
                <div class="product-description">
                    <p style="font-family:monoscope; font-size:22px">Ce produit exceptionnel offre une qualité premium à un prix abordable.</p>
                </div>
                <?php
                $pro = $_SESSION["panier"]["utilisateur"]["id_utilisateur"][$id] ?? 0;
                $button = $pro > 0 ? "modifier" : "ajouter au panier";
                ?>
                <form class="gap-5" method="post" action="afficher_panier.php?id=<?= htmlspecialchars($id) ?>&idd=<?= htmlspecialchars($idd) ?>&prix=<?= htmlspecialchars($prix) ?>&lib=<?= htmlspecialchars($lib) ?>&img=<?= htmlspecialchars($image) ?>&qte=<?= htmlspecialchars($qte) ?>">
                    <div class="quantity-selector">
                        <button onclick="return false;" class="quantity-btn minus"><i class="fas fa-minus"></i></button>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                        <input type="number" name="qt" class="quantity-input" value="<?= $pro > 0 ? $pro : 1 ?>" min="1">
                        <button onclick="return false;" class="quantity-btn plus"><i class="fas fa-plus"></i></button>
                    </div>
                <?php if ($qte > 0): ?>
                      <button type="submit" class="btn btn-custom" name="ajouter">
                        <i class="fas fa-shopping-cart me-2"></i> <?= $button ?>
                    </button>
                    <hr>
                    <p><strong>Disponibilité:</strong> <span class="text-success">En stock</span></p>
                <?php else: ?>
                    <button type="submit" class="btn btn-custom" name="ajouter" disabled>
                        <i class="fas fa-shopping-cart me-2"></i> <?= $button ?>
                    </button>
                    <hr>
                    <p><strong>Disponibilité:</strong> <span class="text-danger">Rupture de stock</span></p>
                <?php endif; ?>
                
            </form>
            </div>
        </div>
    </div>
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>MonShop</h5>
                    <p>Votre boutique en ligne préférée pour des produits de qualité.</p>
                </div>
                <div class="col-md-4">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Accueil</a></li>
                        <li><a href="#" class="text-white">Produits</a></li>
                        <li><a href="#" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p><i class="fas fa-envelope me-2"></i> contact@khalidshop.com</p>
                    <p><i class="fas fa-phone me-2"></i> +212 6 05 75 63 69</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.minus').addEventListener('click', function() {
            const input = document.querySelector('.quantity-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });

        document.querySelector('.plus').addEventListener('click', function() {
            const input = document.querySelector('.quantity-input');
            input.value = parseInt(input.value) + 1;
        });
    </script>
</body>
</html>