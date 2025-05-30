<?php
include "navbar.php";

$stmt =$conn->prepare("SELECT * FROM categorie");
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
        LISTE DES CATEGORIES
</div><br>
<table class="container table table-striped table-hover">
<tr>
    <th>id</th>
    <th>libelle</th>
    <th>description</th>
    <th>date de creation</th>
    <th>action</th>
</tr>
<?php
foreach($results as $result){
    echo "<tr>
    <td>$result[id]</td>
      <td>$result[libelle]</td>
        <td>$result[description]</td>
          <td>$result[date_creation]</td>
          <td>
<a class='btn btn-success' href='modifier_categorie.php?id=$result[id]&libell=$result[libelle]&des=$result[description]' style='text-decoration:none;color:white;' >modifier</a>
          <a class='btn btn-danger' href='supprimer_categorie.php?id=$result[id]' onclick='return confirm('vous voulez vraimant supprimer ?');' style='text-decoration:none;color:white;'>supprimer</a>";
        
}
?>
</table>
</body>
</html>