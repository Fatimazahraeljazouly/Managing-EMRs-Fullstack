<?php
include 'dashboard.php';
    include '../includs/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['idSec'])) {
    die("Erreur : Secrétaire non connecté.");
}

$idSec = $_SESSION['idSec'];
$update_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['nom']) || isset($_POST['prenom']) || isset($_POST['cin']))) {
    $nome = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $cin = $_POST['cin'] ?? '';
    $nome_like = "%$nome%";
    $prenom_like = "%$prenom%";
    $cin_like = "%$cin%";

    // Requête SQL pour rechercher des utilisateurs correspondant aux critères et ajoutés par le secrétaire connecté
    $stmt = $conn->prepare("SELECT u.idUtilisateur, u.username,u.role, u.nom, u.cin, u.prenom, p.datenaissance, p.adresse, u.email, u.sexe, u.telephone, p.idPt
                            FROM utilisateur u 
                            JOIN patient p ON u.idUtilisateur = p.idUtilisateur 
                            WHERE p.idSecretaire = ? 
                            AND u.nom LIKE ? 
                            AND u.prenom LIKE ? 
                            AND u.cin LIKE ?");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("isss", $idSec, $nome_like, $prenom_like, $cin_like);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $update_message = "Aucun utilisateur trouvé avec ces critères.";
    }

    $stmt->close();
}

// Fonction pour mettre à jour les informations de l'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $nome = $_POST['nome'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $sexe = $_POST['sexe'];
    $cin = $_POST['cin'];
    $role = $_POST['role'];
    $datenaissance = $_POST['datenaissance'];
    $address = $_POST['addresse'];
    $idPt = $_POST['idPt'];

    // Préparation de la requête SQL pour la mise à jour de l'utilisateur
    $stmt = $conn->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, username = ?, email = ?, telephone = ?, sexe = ?, cin = ?, role = ? WHERE idUtilisateur = ?");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("ssssssssi", $nome, $prenom, $username, $email, $telephone, $sexe, $cin, $role, $user_id);
    
    if ($stmt->execute()) {
        // Préparation de la requête SQL pour la mise à jour du patient
        $stmt = $conn->prepare("UPDATE patient SET datenaissance = ?, adresse = ? WHERE idUtilisateur = ? AND idPt = ?");
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }
        $stmt->bind_param("ssii", $datenaissance, $address, $user_id, $idPt);

        if ($stmt->execute()) {
            $update_message = "Informations de Patient mises à jour avec succès.";
        } else {
            $update_message = "Erreur de mise à jour du patient : " . $stmt->error;
        }
    } else {
        $update_message = "Erreur de mise à jour de Patient : " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="page">
        <div class="top">
            <h2>Modifier Patient</h2>
            <a href="infosPerso.php">
                <img  src="../icons/secritaireIcon.png" alt="Admin Profile Picture">
            </a>
        </div>

        <div class="content">
            <!-- Formulaire de recherche -->
            <div class="search-user-form">
                <h2>Rechercher un Patient</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="cin">CIN:</label>
                        <input type="text" id="cin" name="cin">
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom">
                    </div>
                    <button type="submit">Rechercher</button>
                </form>
            </div>
            
        
            <!-- Formulaire de modification si l'utilisateur est trouvé -->
            <?php if (isset($user) && $user): ?>
            <div class="edit-user-form">
                <h2>Modifier les informations de Patient</h2>
                <form action="" method="post">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['idUtilisateur']); ?>">
                    <input type="hidden" name="idPt" value="<?php echo htmlspecialchars($user['idPt']); ?>">
                    <div class="form-group">
                        <label for="nome">Nom:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur:</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone:</label>
                        <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['telephone']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="datenaissance">Date de Naissance:</label>
                        <input type="date" id="datenaissance" name="datenaissance" value="<?php echo htmlspecialchars($user['datenaissance']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="addresse">Adresse:</label>
                        <input type="text" id="addresse" name="addresse" value="<?php echo htmlspecialchars($user['adresse']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="sexe">Sexe:</label>
                        <select id="sexe" name="sexe" required>
                            <option value="m" <?php if ($user['sexe'] == 'm') echo 'selected'; ?>>Masculin</option>
                            <option value="f" <?php if ($user['sexe'] == 'f') echo 'selected'; ?>>Féminin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cin">CIN:</label>
                        <input type="text" id="cin" name="cin" value="<?php echo htmlspecialchars($user['cin']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Rôle:</label>
                        <select id="role" name="role" required>
                            <option value="patient" <?php if ($user['role'] == 'patient') echo 'selected'; ?>>Patient</option>
                        </select>
                    </div>
                    <button type="submit" name="update">Mettre à jour</button>
                </form>
                <?php if (!empty($update_message)): ?>
                    <p><?php echo $update_message; ?></p>
                <?php endif; ?>
            </div>
            <?php elseif (isset($update_message)): ?>
                <p><?php echo $update_message; ?></p>
            <?php endif; ?>
        </div>
        <?php include 'footer.php'; ?>

    </div>
</body>
</html>
