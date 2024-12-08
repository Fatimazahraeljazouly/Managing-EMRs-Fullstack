<?php
include '../includs/db.php';
$update_msg="";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['motdepass'];
    $confirmNewPassword = $_POST['confirme_motdepass'];
    $userId = $_POST['user_id']; // Assumes you store the user ID in session

    // Fetch current password from database
    $sql = "SELECT motdepasse FROM utilisateur WHERE idUtilisateur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($dbPassword);
    $stmt->fetch();
    $stmt->close();
    // Verify current password (since it's stored in plain text)
    if  (password_verify($currentPassword , $dbPassword)) {
        if ($newPassword === $confirmNewPassword) {
            $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
            // Update password in database (you should hash it in the future)
            $sql = "UPDATE utilisateur SET motdepasse = ? WHERE idUtilisateur = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $hashed_password, $userId);
            if ($stmt->execute()) {
                $update_msg="Mot de passe mis à jour avec succès.";
            } else {
                $update_msg="Erreur lors de la mise à jour du mot de passe.";
            }
            $stmt->close();
        } else {
            $update_msg= "Les nouveaux mots de passe ne correspondent pas.";
        }
    } else {
        $update_msg="Le mot de passe actuel est incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Administrateur</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php 
include 'dashboard.php'; 
include '../includs/db.php';
?>

<!-- Page content -->
<div class="page">
    <div class="top">
        <h2>Mon Profile</h2>
        <a href="infosPerso.php">
                <img  src="../icons/secritaireIcon.png" alt="Admin Profile Picture">
            </a>
    </div>
    
    <div class="content">
        <div class="admin-profile">
            <?php


if (isset($_SESSION['idSec'])) {
    $idSec = $_SESSION['idSec'];}

    // Modifiez la requête SQL pour inclure la condition sur idSec
    $sql = "SELECT u.idUtilisateur, u.username, u.email, u.prenom, u.nom, u.telephone, u.role 
            FROM utilisateur u 
            JOIN secretaire a ON u.idUtilisateur = a.idUtilisateur 
            WHERE a.idSec = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idSec);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
/*                     $sql = "SELECT u.idUtilisateur,u.username, u.email, u.prenom, u.nom, u.telephone, u.role FROM utilisateur u, secretaire a WHERE u.idUtilisateur = a.idUtilisateur ;";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc(); */
                    
    ?>
            <form method="post" action="">
            <input type="hidden" name="user_id" value="<?php echo $row['idUtilisateur']; ?>">
            <div class="form-group">
                     <label style="color:red; font-weight:600; font-size:20px;" for="current-password">Changer Votre Mot de Passe</label>
                </div>
                <?php if (isset($update_msg)): ?>
                <p><?php echo $update_msg; ?></p>
            <?php endif; ?>
                <div class="form-group">
                    <label for="username">Nom d'utilisateur:</label>
                    <p><?php echo $row['username']; ?></p>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <p><?php echo $row['email']; ?></p>
                </div>
                <div class="form-group">
                    <label for="prenom">Nom et Prénom:</label>
                    <p><?php echo $row['prenom']; echo "  "; echo $row['nom'];?></p>
                </div>
                <div class="form-group">
                    <label for="telephone">Téléphone:</label>
                    <p><?php echo $row['telephone']; ?></p>
                </div>
                <div class="form-group">
                    <label for="current-password">Mot de passe actuel:</label>
                    <input type="password" id="current-password" name="current_password" placeholder="Entrez votre mot de passe actuel" required>
                </div>
                <div class="form-group">
                    <label for="motdepass">Nouveau mot de passe:</label>
                    <input type="password" id="motdepass" name="motdepass" placeholder="Entrez le nouveau mot de passe">
                </div>
                <div class="form-group">
                    <label for="confirme-motdepass">Confirmer nouveau mot de passe:</label>
                    <input type="password" id="confirme-motdepass" name="confirme_motdepass" placeholder="Confirmez le nouveau mot de passe">
                </div>
                <button type="submit" class="btn btn-primary">Modifier</button>
            </form>
        </div>
        <?php if (isset($update_msg)): ?>
                <p><?php echo $update_msg; ?></p>
            <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</div>
</body>
</html>
