
<?php 
 include ("../includs/db.php");
 session_start();
 $errmsg="";
    if($_SERVER["REQUEST_METHOD"] ="POST" && isset($_POST["MotDePass"])&& isset($_POST["Utilisateur"]) ){
        $username = $_POST["Utilisateur"];
        $password = $_POST["MotDePass"];

        $sql= "SELECT u.motdepasse ,m.idMd from utilisateur u , medecin m where u.idUtilisateur=m.idUtilisateur AND username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >0){
            $row=$result->fetch_assoc();
            $hashedpassword=$row["motdepasse"];
            if(password_verify($password,$hashedpassword)){
                $_SESSION["idMd"]=$row["idMd"];
                $_SESSION["username"]=$username;
                header("location:index.php");
                exit();
            }else{
                $errmsg="Utilisateur ou Mot de passe incorrecte";
            }
        }else{
            $errmsg="Utilisateur ou Mot de passe incorrecte";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système GDME</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styleLogin.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card login-card p-4">
            <div class="card-body">
                <img   src="../icons/medcinIcon.png" alt="" style="margin-left: 40%;">
                <h2 class="text-center mb-4">Connexion Medecin</h2>
                <hr>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="Utilisateur">Nom D'Utilisateur</label>
                        <input type="text" name="Utilisateur" id="Utilisateur" class="form-control" placeholder="Utilisateur" required>
                    </div>
                    <div class="form-group">
                        <label for="MotDePass">Mot de Passe</label>
                        <input type="password" name="MotDePass" id="MotDePass" class="form-control" placeholder="Mot de Passe" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="../index.php" class="text-muted">Retour</a>
                        <a href="#" class="text-muted">Mot de Passe Oublié?</a>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-block mt-4">Connexion</button>
                </form>
                <?php if(isset($errmsg)) :?>
                    <p style="color:#ff2e2e; background-color:#ffeaea; border-radius:6px; text-align:center; "><?php echo $errmsg; ?></p>
                <?php endif;?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
