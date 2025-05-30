<?php
$connecte = isset($_SESSION["utilisateur"]);
include "navbar.php";
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
    
    <title>KhalidShop - Votre boutique en ligne</title>
    
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
   
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3 hero-text">Découvrez notre collection</h1>
                    <p class="lead mb-4">Les meilleures offres sur des produits de qualité. Explorez notre boutique aujourd'hui et profitez de prix imbattables.</p>
                    <div class="d-flex gap-3">
                        <a href="achat.php" class="btn btn-primary px-4 py-2">Nos produits</a>
                        <a href="#promos" class="btn btn-outline-primary px-4 py-2">Promotions</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
 
        <div class="text-center mt-4">
            <a href="achat.php" class="btn btn-outline-primary">Voir tous les produits</a>
        </div>
    </section>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">À propos de KhalidShop</h5>
                    <p class="text-light">Votre boutique en ligne de confiance depuis 2020. Nous proposons des produits de qualité à des prix compétitifs.</p>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5 class="mb-3">Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">À propos</a></li>
                        <li><a href="#" class="text-light">Contactez-nous</a></li>
                        <li><a href="#" class="text-light">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5 class="mb-3">Suivez-nous</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-light fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light fs-5"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <h5 class="mb-3">Newsletter</h5>
                    <form>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Votre email">
                            <button class="btn btn-primary" type="button">S'abonner</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-light">
                <small>&copy; <?php echo date('Y'); ?> KhalidShop. Tous droits réservés.</small>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>