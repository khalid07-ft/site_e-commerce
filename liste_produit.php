<?php
include "navbar.php";
$stmt =$conn->prepare("SELECT * FROM produit");
$stmt->execute();
$results = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="text-align:center; font-size:30px;font-family:monoscope;">
        LISTE DES PRODUITS
</div><br>
<table class="container table table-striped table-hover">
<tr>
    <th>id</th>
    <th>libelle</th>
    <th>prix</th>
    <th>discount </th>
    <th>date de creation</th>
    <th>action</th>
</tr>
<?php
foreach($results as $result){
    echo "<tr>
    <td>$result[id_produit]</td>
      <td>$result[libelle]</td>
        <td>$result[prix] DH</td>
          <td>$result[discount] %</td>
          <td>$result[date_creation]</td>
          <td>
<a class='btn btn-success' href='modifier_produit.php?id=$result[id_produit]&libell=$result[libelle]&des=$result[prix]&disc=$result[discount]&cre=$result[date_creation]' style='text-decoration:none;color:white;' >modifier</a>
<a class='btn btn-danger' href='supprimer_produit.php?id=$result[id_produit]'  style='text-decoration:none;color:white;'>supprimer</a>
          </td>
          </tr>";
}
?>
</table>
</body>
</html>