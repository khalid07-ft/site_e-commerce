<?php
include "index.php";
$id=$_GET["id"];
$stmt=$conn->prepare("DELETE FROM produit WHERE id_produit=? ");
$stmt->execute([$id]);
header ("location:liste_produit.php");
?>