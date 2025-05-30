<?php
include "navbar.php";
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_POST["ajouter"])){
        if(!empty($_POST["libelle"]) && !empty($_POST["description"])){
            $libelle = $_POST["libelle"];
            $des= $_POST["description"];
        $sql=$conn->prepare("INSERT INTO categorie (libelle,description) VALUES (?,?)");
        $sql->execute([$libelle,$des]);
        echo "<div class='alert alert-success container' role='alert'>
        ajout ".$des." avec success !
        </div>";
        }
        else{
            echo "<div class='alert alert-danger container' role='alert'>
        remplissez tous les champs !
        </div>";
        }
    }
    ?>
<form action="ajouter_categorie.php" method="post" class="container">
  <label class="form-label">LIBELLe</label>
  <input type="text" name="libelle" class="form-control"><br>
  <label class="form-label">DESCRIPTION</label>
  <input type="text" class="form-control" name="description"><br>
  <input type="submit" value="ajouter" name="ajouter" class="btn btn-success">
</form>
</body>
</html>