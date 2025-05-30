<?php
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma,  Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
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
<body><?php
if (isset($_POST["ajouter"])){
    if(!empty($_POST["mail"] && !empty($_POST["password"]))){
        $mail = $_POST["mail"];
        $password = $_POST["password"];
        $date=date(format:'y-m-d');
        $sql = $conn->prepare("INSERT INTO utilisateur (login,password,date_creation) VALUES (?,?,?)");
        $sql->execute([$mail,$password,$date]);
         echo "<div class='alert alert-success container' role='alert'>
         l'ajout Avec success 
         </div>";
         header ("location:inscription.php");
    }
    else{
        echo "<div class='alert alert-danger container' role='alert'>
        email or password is empty !
        </div>";
    }
}
?>
<form action="login.php" method="post" class="f container mt-5">
  <label class="form-label">gmail</label>
  <input type="email" name="mail" class="form-control"> <br>
  <label class="form-label">password</label>
  <input type="password"class="form-control" name="password" > <br>
  <input type="submit" value="sign" name="ajouter" class="btn btn-success form-control">
</form>


</body>
</html>