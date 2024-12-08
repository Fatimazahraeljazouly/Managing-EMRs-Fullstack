<?php
session_start();
include '../includs/db.php';

$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $motdepasse = $conn->real_escape_string($_POST['motdepasse']);

    // Requête pour vérifier les informations de connexion
    $sql = "SELECT * FROM admin a, utilisateur u WHERE u.idUtilisateur = a.idUtilisateur AND u.username = ? AND u.motdepasse = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $motdepasse);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['admin'] = $username;
        $_SESSION['idAdmin'] = $row["idAdmin"];
        header("Location: index.php");
        exit();
    } else {
        $errorMsg = "Nom d'utilisateur ou mot de passe incorrect";
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
                <img src="../icons/adminIcon.png" alt="" style="margin-left: 40%;">
                <h2 class="text-center mb-4">Connexion Administrateur</h2>
                <hr>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="username">Nom D'Utilisateur</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Utilisateur" required>
                    </div>
                    <div class="form-group">
                        <label for="motdepasse">Mot de Passe</label>
                        <input type="password" name="motdepasse" id="motdepasse" class="form-control" placeholder="Mot de Passe" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="../index.php" class="text-muted">Retour</a>
                        <a href="#" class="text-muted">Mot de Passe Oublié?</a>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-block mt-4">Se Connecter</button>
                </form>
            </div>
            <?php if (isset($errorMsg)): ?>
                <p style="color:#ff2e2e; background-color:#ffeaea; border-radius:6px; text-align:center; " ><?php echo $errorMsg; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
