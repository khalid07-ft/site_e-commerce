<?php
session_start();
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
    <style>
        button a{
            text-decoration: none;
            color:white;
        }
        .f{
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 40px;
        }
    </style>
</head>
<body>
    <?php
    if (!isset($_POST["ajouter"])) {
        $_SESSION["tentative"] = 0;
    }
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST["ajouter"])){ 
        if(!empty($_POST["mail"]) && !empty($_POST["password"])){
            $mail = $_POST["mail"];
            $password = $_POST["password"];
            $sql = $conn->prepare("SELECT * FROM utilisateur WHERE login=? AND password=? ");
            $sql->execute([$mail, $password]);
            $f = $sql->rowCount(); # 1 or 0
            if($f > 0 ){
                $_SESSION["utilisateur"]=$sql->fetch(PDO::FETCH_ASSOC);
                $_SESSION["id"] = $_SESSION["utilisateur"]["id_utilisateur"]; 
                header("location:index.php");
            }
            if($_SESSION["tentative"] <= 2){
                $_SESSION["tentative"]++;
                echo "<div class='alert alert-danger container' role='alert'>
                email or password is empty !<br>
                votre chance est de ".$_SESSION["tentative"]."/3
                </div>";
            }
            if($_SESSION["tentative"] > 2){
                header("location:login.php");
            }
        }
    }
}
    ?>
  
<form action="inscription.php" method="post" class="f container was-validated mt-5">
  <label class="form-label">gmail</label>
  <input type="email" name="mail" class="form-control" required> <br>
  <label class="form-label">password</label>
  <input type="password" class="form-control" name="password" required> <br>
  <input type="submit" value="login" name="ajouter" class="btn btn-success">
  <button type="submit" class="btn btn-danger mx-2" name="btn"><a href="login.php">sign</a></button>
</form>
    
</body>
</html>