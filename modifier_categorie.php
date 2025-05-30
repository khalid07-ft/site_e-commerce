<?php
include "navbar.php";
if(!isset($_POST{"modifier"})){
$id=$_GET["id"];
$libelle=$_GET["libell"];
$desc=$_GET["des"];
}
if(isset($_POST["modifier"])){
    $id=$_POST["id"];
    $libelle=$_POST["libelle"];
    $desc=$_POST["description"];
$stmt=$conn->prepare("UPDATE categorie SET libelle=?,description=? WHERE id=?");
$stmt->execute([$libelle,$desc,$id]);
header ("location:liste_categorie.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="modifier_categorie.php" method="post" class="container">
<label class="form-label">ID</label>
<input type="number" name="id" value="<?php echo  $id ;?>" class="form-control"><br>
  <label class="form-label">LIBELLe</label>
  <input type="text" name="libelle" value="<?php echo  $libelle ;?>" class="form-control"><br>
  <label class="form-label">DESCRIPTION</label>
  <input type="text" class="form-control"  value="<?php echo  $desc ;?>" name="description"><br>
  <input type="submit" value="modifier" name="modifier" class="btn btn-success">
</form>
</body>
</html>