<?php
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
if(!isset($_POST["modifier"])){
    $id = $_GET["id"];
    $libelle = $_GET["libell"];
    $desc = $_GET["des"];
    $disc = $_GET["disc"];
    $cree=$_GET["cre"];
}
if(isset($_POST["modifier"])){
    $id = $_POST["id"];
    $libelle = $_POST["libelle"];
    $prix = $_POST["prix"];
    $dis = $_POST["discount"];
    $stmt = $conn->prepare("UPDATE produit SET  libelle=?, prix=?, discount=? WHERE id_produit=?");
    $stmt->execute([$libelle,$prix, $dis,$id]);
    header ("location:liste_produit.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<form action="modifier_produit.php" method="post" class="container">
    <label class="form-label">ID</label>
    <input type="number" name="id" value="<?php echo $id; ?>" class="form-control" readonly><br>
    <label class="form-label">LIBELLE</label>
    <input type="text" name="libelle" value="<?php echo $libelle; ?>" class="form-control"><br>
    <label class="form-label">prix</label>
    <input type="number" class="form-control" value="<?php echo $desc; ?>" name="prix"><br>
    <label class="form-label">discount</label>
    <input type="number" class="form-control" value="<?php echo $disc; ?>" name="discount"><br>
    <input type="submit" value="modifier" name="modifier" class="btn btn-success">
</form>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>