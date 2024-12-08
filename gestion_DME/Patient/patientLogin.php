<?php
include("../includs/db.php");
session_start();

$errmsg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["MotDePass"]) && isset($_POST["Utilisateur"])) {
    $username = $_POST["Utilisateur"];
    $password = $_POST["MotDePass"];

    // Préparer la requête SQL
    $sql = "SELECT u.motdepasse,u.username, m.idPt FROM utilisateur u JOIN patient m ON u.idUtilisateur = m.idUtilisateur WHERE u.username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedpassword = $row["motdepasse"];
        if (password_verify($password, $hashedpassword)) {
            // Connexion réussie
            $_SESSION["idPt"] = $row["idPt"];
            $_SESSION["patinet"] = $username;
            header("Location: index.php");
            exit();
        } else {
            $errmsg = "Utilisateur ou Mot de passe incorrecte";
        }
    } else {
        $errmsg = "Utilisateur ou Mot de passe incorrecte";
    }

    $stmt->close();
}

$conn->close();
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
                <img src="../icons/patientIcon.png" alt="Patient Icon" style="margin-left: 40%; max-width: 100px;">
                <h2 class="text-center mb-4">Connexion Patient</h2>
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
                    <?php if (!empty($errmsg)): ?>
                        <div class="alert alert-danger"><?php echo $errmsg; ?></div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between">
                        <a href="../index.php" class="text-muted">Retour</a>
                        <a href="#" class="text-muted">Mot de Passe Oublié?</a>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-block mt-4">Connexion</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
