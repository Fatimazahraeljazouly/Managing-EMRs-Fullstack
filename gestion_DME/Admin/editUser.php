<?php
include '../includs/db.php'; // Assurez-vous que le chemin est correct
error_reporting(E_ALL);
ini_set('display_errors', 1);

$update_message = '';

// Fonction pour rechercher un utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cin']) && isset($_POST['nom']) && isset($_POST['prenom'])) {
    $cin = $_POST['cin'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    // Requête SQL pour rechercher l'utilisateur correspondant aux critères
    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE cin = ? AND nom = ? AND prenom = ?");
    $stmt->bind_param("sss", $cin, $nom, $prenom);
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

    // Préparation de la requête SQL pour la mise à jour de l'utilisateur
    $stmt = $conn->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, username = ?, email = ?, telephone = ?, sexe = ?, cin = ?, role = ? WHERE idUtilisateur = ?");
    $stmt->bind_param("ssssssssi", $nome, $prenom, $username, $email, $telephone, $sexe, $cin, $role, $user_id);

    if ($stmt->execute()) {
        $update_message = "Informations utilisateur mises à jour avec succès.";
    } else {
        $update_message = "Erreur : " . $stmt->error;
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
    <?php include 'dashboard.php'; ?>

    <div class="page">
        <div class="top">
            <h2>Modifier Utilisateur</h2>
            <a href="index.php">
                <img src="../icons/adminIcon.png" alt="Admin Profile Picture">
            </a>
        </div>

        <div class="content">
            <!-- Formulaire de recherche -->
            <div class="search-user-form">
                <h2>Rechercher un utilisateur</h2>
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
            <?php if (isset($user)): ?>
            <div class="edit-user-form">
                <h2>Modifier les informations de l'utilisateur</h2>
                <form action="" method="post">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['idUtilisateur']); ?>">
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
                            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; echo 'disabled';?>>Administrateur</option>
                            <option value="infirmier" <?php if ($user['role'] == 'infirmier') echo 'selected'; echo 'disabled';?>>Infirmier</option>
                            <option value="medecin" <?php if ($user['role'] == 'medecin') echo 'selected'; echo 'disabled';?>>Médecin</option>
                            <option value="secretaire" <?php if ($user['role'] == 'secretaire') echo 'selected';echo 'disabled'; ?>>Secrétaire</option>
                        </select>
                    </div>
                    <button type="submit" name="update">Mettre à jour</button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Affichage des messages -->
            <?php if (isset($update_message)): ?>
                <p><?php echo $update_message; ?></p>
            <?php endif; ?>
        </div>

        <?php include 'footer.php'; ?>
    </div>
</body>
</html>