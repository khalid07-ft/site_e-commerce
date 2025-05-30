<?php
include "navbar.php";
$sql= $conn->prepare("SELECT *  FROM categorie ");
$sql->execute();
$libelles=$sql->fetchALL(PDO::FETCH_ASSOC);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $image="";
    if(isset($_FILES["image"])){
        $image= $_FILES["image"]["name"];
        $files=$image;
    }

        if(isset($_POST["ajouter"])){
        if(!empty($_POST["libelle"]) && !empty($_POST["prix"])  && !empty($_POST["id"])){
            $libelle = $_POST["libelle"];
            $prix= $_POST["prix"];
            $disc=$_POST["discount"];
            $id=$_POST["id"];
        $sql=$conn->prepare("INSERT INTO produit (libelle,prix,discount,id_categorie,image) VALUES (?,?,?,?,?)");
        $sql->execute([$libelle,$prix,$disc,$id,$files]);
        echo "<div class='alert alert-success container' role='alert'>
        ajout ".$libelle." avec success !
        </div>";
        }
        else{
            echo "<div class='alert alert-danger container' role='alert'>
        remplissez tous les champs !
        </div>";
        }
    
    }
    ?>
<form action="ajouter_produit.php" method="post" class="container" enctype="multipart/form-data">
  <label class="form-label">LIBELLE</label>
  <input type="text" name="libelle" class="form-control"><br>
  <label class="form-label">PRIX</label>
  <input type="number" class="form-control" name="prix"><br>
  <label class="form-label">DISCOUNT</label>
  <input type="number"  max="90" class="form-control" name="discount"><br>
  <label class="form-label">IMAGE</label>
  <input type="file"class="form-control" name="image"><br>
<select name="id">
    <?php
    foreach($libelles as $libelle){
        echo "<option  value='$libelle[id]'>$libelle[libelle]</option>";
    }
    ?>
</select>
  <input type="submit" value="ajouter" name="ajouter" class="btn btn-success">
</form>
</body>
</html>