<?php
include '../includs/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
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
    $role = $_POST['role'];

    // Validation des mots de passe
    if ($password !== $confirm_password) {
        $_SESSION['alert_message'] = "Les mots de passe ne correspondent pas.";
        $_SESSION['alert_type'] = "error";
        header("Location: addUser.php");
        exit();
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparation de la requête SQL pour l'insertion de l'utilisateur
    $stmt = $conn->prepare("INSERT INTO utilisateur (nom, prenom, username, motdepasse, email, telephone, sexe, cin, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nome, $prenom, $username, $hashed_password, $email, $telephone, $sexe, $cin, $role);

    // Exécution de la requête pour ajouter l'utilisateur
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id; // Récupérer l'ID de l'utilisateur inséré

        // Gestion des champs spécifiques en fonction du rôle
        if ($role == "medecin") {
            $medecin_field1 = $_POST['specialitemd'];
            // Préparation et exécution de la requête pour ajouter les détails du médecin
            $stmt = $conn->prepare("INSERT INTO medecin (idUtilisateur, specialite) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $medecin_field1);
            if (!$stmt->execute()) {
                $_SESSION['alert_message'] = "Erreur d'insertion du médecin : " . $stmt->error;
                $_SESSION['alert_type'] = "error";
            }
        } elseif ($role == "infirmier") {
            $infirmier_field1 = $_POST['specialiteif'];
            // Préparation et exécution de la requête pour ajouter les détails de l'infirmier
            $stmt = $conn->prepare("INSERT INTO infirmier (idUtilisateur, specialte) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $infirmier_field1);
            if (!$stmt->execute()) {
                $_SESSION['alert_message'] = "Erreur d'insertion de l'infirmier : " . $stmt->error;
                $_SESSION['alert_type'] = "error";
            }
        } elseif ($role == "secretaire") {
            // Préparation et exécution de la requête pour ajouter les détails de la secrétaire
            $stmt = $conn->prepare("INSERT INTO secretaire (idUtilisateur) VALUES (?)");
            $stmt->bind_param("i", $user_id);
            if (!$stmt->execute()) {
                $_SESSION['alert_message'] = "Erreur d'insertion de la secrétaire : " . $stmt->error;
                $_SESSION['alert_type'] = "error";
            }
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
    <script>
        function showSpecificForm() {
            var role = document.getElementById("role").value;
            var medecinForm = document.getElementById("medecinForm");
            var infirmierForm = document.getElementById("infirmierForm");
            var secretaireForm = document.getElementById("secretaireForm");

            medecinForm.style.display = "none";
            infirmierForm.style.display = "none";
            secretaireForm.style.display = "none";

            if (role === "medecin") {
                medecinForm.style.display = "block";
            } else if (role === "infirmier") {
                infirmierForm.style.display = "block";
            } else if (role === "secretaire") {
                secretaireForm.style.display = "block";
            }
        }

        function showAlert(message, type) {
            var alertContainer = document.getElementById('alert-container');
            var alertDiv = document.createElement('div');
            alertDiv.className = 'alert ' + (type === 'success' ? 'alert-success' : 'alert-error');
            alertDiv.innerHTML = message + '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
            alertContainer.appendChild(alertDiv);

            // Disparition automatique de l'alerte après 5 secondes
            setTimeout(function () {
                alertDiv.style.display = 'none';
            }, 5000);
        }
    </script>
</head>
<body>
<div id="alert-container"></div>
<?php include 'dashboard.php'; ?>
    <div class="page">
        <div class="top">
            <h2>Ajouter Utilisateur</h2>
            <a href="infoPerso.php">
                <img src="../icons/adminIcon.png" alt="Admin Profile Picture">
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
                        <label for="role">Rôle:</label>
                        <select id="role" name="role" required onchange="showSpecificForm()">
                            <option value="infirmier">Infirmier</option>
                            <option value="medecin">Médecin</option>
                            <option value="secretaire">Secrétaire</option>
                        </select>
                    </div>

                    <div id="medecinForm" style="display:none;">
                        <h3>Informations Spécifiques au Médecin</h3>
                        <div class="form-group">
                            <label for="specialitemd">Spécialité :</label>
                            <input type="text" id="specialitemd" name="specialitemd">
                        </div>
                    </div>
                    <div id="infirmierForm" style="display:none;">
                        <h3>Informations Spécifiques à l'Infirmier</h3>
                        <div class="form-group">
                            <label for="specialiteif">Spécialité :</label>
                            <input type="text" id="specialiteif" name="specialiteif">
                        </div>
                    </div>
                    <div id="secretaireForm" style="display:none;">
                        <h3>Informations Spécifiques à la Secrétaire</h3>
                    </div>

                    <button type="submit" name="add">Ajouter Utilisateur</button>
                </form>
            </div>
        </div>
        
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
