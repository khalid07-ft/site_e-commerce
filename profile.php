
<?php
include "navbar.php";
$stmt=$conn->prepare("SELECT * from utilisateur where id_utilisateur=?");
$stmt->execute([$_SESSION["id_utilisateur"]]);
$f=$stmt->fetch(PDO::FETCH_ASSOC);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            
            color: #333;
        }
        
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .profile-header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .profile-header p {
            color: #7f8c8d;
        }
        
        .profile-info {
            margin-bottom: 25px;
        }
        
        .info-group {
            margin-bottom: 15px;
        }
        
        .info-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .info-value {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        
        .password-mask {
            letter-spacing: 2px;
            font-family: monospace;
        }
        
        .creation-date {
            font-style: italic;
            color: #7f8c8d;
            font-size: 0.9em;
            margin-top: 30px;
            text-align: center;
        }
        
        .edit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            display: block;
            margin: 30px auto 0;
            transition: background-color 0.3s;
        }
        
        .edit-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body><br><br>
<?php if($f) :?>
    <div class="profile-container">
        <div class="profile-header">
            <h1>User Profile</h1>
            <p>Manage your account information</p>
        </div>
        
        <div class="profile-info">
            <div class="info-group">
                <label for="login">Login</label>
                <div class="info-value" id="login"><?= $f["login"] ?></div>
            </div>
            
            <div class="info-group">
                <label for="password">Password</label>
                <div class="info-value">
                    <span class="password-mask">••••••••</span>
                    <a href="#" style="float: right; color: #3498db; text-decoration: none;">Change</a>
                </div>
            </div>
        </div>
        
        <div class="creation-date">
            Account created on: <span id="date_creation"><?= $f["date_creation"] ?></span>
        </div>
        
        <button class="edit-btn">Edit Profile</button>
        <?php endif ;?>
    </div>
</body>
</html>