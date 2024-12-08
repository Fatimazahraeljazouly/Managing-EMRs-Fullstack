<?php
include '../includs/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nome = $_POST['nome'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $sexe = $_POST['sexe'];
    $cin = $_POST['cin'];
    $role = "patient";
    $date_naissance = $_POST['date_naissance'];
    $address = $_POST['address'];
    $idSecretaire= $_SESSION['idSec'];

    // Validation des mots de passe
    if ($password !== $confirm_password) {
        $_SESSION['alert_message'] = "Les mots de passe ne correspondent pas.";
        $_SESSION['alert_type'] = "error";
        header("Location: addUser.php");
        exit();
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //  l'insertion de l'utilisateur
    $stmt = $conn->prepare("INSERT INTO utilisateur (nom, prenom, username, motdepasse, email, telephone, sexe, cin, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        $_SESSION['alert_message'] = "Erreur de préparation de la requête pour l'insertion de l'utilisateur : " . $conn->error;
        $_SESSION['alert_type'] = "error";
        header("Location: addUser.php");
        exit();
    }
    $stmt->bind_param("sssssssss", $nome, $prenom, $username, $hashed_password, $email, $telephone, $sexe, $cin, $role);

    //  ajouter l'utilisateur
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id; //  l'ID de l'utilisateur insere

        //  ajouter les details du patient
        $stmt = $conn->prepare("INSERT INTO patient (idUtilisateur, idSecretaire, adresse, datenaissance) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            $_SESSION['alert_message'] = "Erreur de préparation de la requête pour l'insertion du patient : " . $conn->error;
            $_SESSION['alert_type'] = "error";
            header("Location: addUser.php");
            exit();
        }
        $stmt->bind_param("iiss", $user_id, $idSecretaire, $address, $date_naissance);
        if (!$stmt->execute()) {
            $_SESSION['alert_message'] = "Erreur d'insertion du Patient : " . $stmt->error;
            $_SESSION['alert_type'] = "error";
        }

        if (!isset($_SESSION['alert_message'])) {
            $_SESSION['alert_message'] = "Utilisateur ajouté avec succès.";
            $_SESSION['alert_type'] = "success";
        }
    } else {
        $_SESSION['alert_message'] = "Erreur : " . $stmt->error;
        $_SESSION['alert_type'] = "error";
    }

    // Fermeture de la connexion et du statement
    $stmt->close();
    $conn->close();

    header("Location: addUser.php");
    exit();
}

// Affichage des messages d'alerte si présents
if (isset($_SESSION['alert_message'])) {
    echo '<script>document.addEventListener("DOMContentLoaded", function() {
            showAlert("' . $_SESSION['alert_message'] . '", "' . $_SESSION['alert_type'] . '");
        });</script>';
    unset($_SESSION['alert_message']);
    unset($_SESSION['alert_type']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Utilisateur</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<div id="alert-container"></div>
<?php include 'dashboard.php'; ?>
    <div class="page">
        <div class="top">
            <h2>Ajouter Patient</h2>
            <a href="infosPerso.php">
                <img  src="../icons/secritaireIcon.png" alt="Admin Profile Picture">
            </a>
        </div>
        
        <div class="content">
            <div class="add-user-form">
                <h2>Informations de l'Utilisateur</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nome">Nom:</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmer Mot de passe:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone:</label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                    <div class="form-group">
                        <label for="sexe">Sexe:</label>
                        <select id="sexe" name="sexe" required>
                            <option value="m">Masculin</option>
                            <option value="f">Féminin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cin">CIN:</label>
                        <input type="text" id="cin" name="cin" required>
                    </div>
                    <div class="form-group">
                        <label for="date_naissance">Date de Naissance:</label>
                        <input type="date" name="date_naissance" id="date_naissance" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse:</label>
                        <input type="text" name="address" id="adresse" required>
                    </div>
                    <button type="submit" name="add" >Ajouter Utilisateur</button>
                </form>
            </div>
        </div>
        
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
