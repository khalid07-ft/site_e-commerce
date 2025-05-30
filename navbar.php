<?php
session_start();
$_SESSION["id_utilisateur"]=$_SESSION["id"] ?? null;
$dbConfig = [
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'ecommerce',
    'port' => 3308
];
try {
    $conn = new PDO("mysql:host={$dbConfig['server']};port={$dbConfig['port']};dbname={$dbConfig['database']}", 
                    $dbConfig['username'], 
                    $dbConfig['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    $dbError = true;
}
$connecte = isset($_SESSION["utilisateur"]);
if ($connecte && isset($_SESSION["panier"]["utilisateur"]["id_utilisateur"])) {
    $userCart = $_SESSION["panier"]["utilisateur"]["id_utilisateur"];
    if (is_array($userCart)) {
        $cartItemCount = count(array_keys($userCart));
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="KhalidShop - Votre boutique en ligne de confiance">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #198754;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }
        
        .navbar {
            padding: 0.8rem 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
        }
        
        .nav-link, .dropdown-item {
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .nav-link:hover, .dropdown-item:hover {
            color: var(--primary-color) !important;
            transform: translateX(2px);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .hero {
            background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7)), url('https://images.unsplash.com/photo-1472851294608-062f824d29cc');
            background-size: cover;
            background-position: center;
            padding: 5rem 0;
            margin-bottom: 2rem;
        }
        
        .hero-text {
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .featured-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .featured-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .brand-name {
            font-weight: 700;
        }
        
        .brand-highlight {
            color: var(--secondary-color);
        }
        
        .cart-icon {
            font-size: 1.2rem;
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="black" class="bi bi-shop me-2" viewBox="0 0 16 16">
                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                    </svg>
                <span class="brand-name">Khalid<span class="brand-highlight">Shop</span></span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0 d-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    
                    <?php if($connecte): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Catégories
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item py-2" href="ajouter_categorie.php">Ajouter</a></li>
                                <li><a class="dropdown-item py-2" href="liste_categorie.php">Afficher</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Produits
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item py-2" href="ajouter_produit.php">Ajouter</a></li>
                                <li><a class="dropdown-item py-2" href="liste_produit.php">Afficher</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="achat.php">Commandes</a>
                        </li>
                        <li class="nav-item ms-2">
    <a class="btn btn-outline-primary position-relative" href="afficher_panier.php" aria-label="Panier">
        <i class="fa-solid fa-cart-shopping fa-flip-horizontal cart-icon"></i>
        <?php if (!empty($cartItemCount) && $cartItemCount > 0 ): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo $cartItemCount ?? 0?>
            </span>
        <?php endif; ?>
    </a>
</li>
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user-circle fs-5"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item py-2" href="profile.php">Mon profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2" href="deconnexion.php">Déconnexion</a></li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Connexion</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary" href="inscription.php">Inscription</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>