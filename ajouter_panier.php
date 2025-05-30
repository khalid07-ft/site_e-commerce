<?php
include "index.php";

$id=$_POST["id"];
$qt=$_POST["qt"];
if(!isset($_SESSION["utilisateur"])) {
    header("location:login.php");
}
if(!empty($id) && !empty($qt)){
    if(!isset($_SESSION["panier"]["utilisateur"]['id_utilisateur'])){
        $_SESSION["panier"]["utilisateur"]['id_utilisateur']=[];
    }
if($qt>0){
    $_SESSION["panier"]["utilisateur"]['id_utilisateur'][$id]=$qt;
}
else{
    unset($_SESSION["panier"]["utilisateur"]['id_utilisateur'][$id]);
}
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
    
</body>
</html>