<?php
include "index.php";
$id=$_GET["id"];
$stmt=$conn->prepare("DELETE FROM categorie WHERE id=? ");
$stmt->execute([$id]);
header ("location:liste_categorie.php");
?>