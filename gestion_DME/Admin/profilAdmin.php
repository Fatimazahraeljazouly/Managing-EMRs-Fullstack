<?php
include 'dashboard.php'; 
include '../includs/db.php';
$update_msg="";

if (isset($_SESSION['admin']) && isset(  $_SESSION['idAdmin'] )) {
    $id =  $_SESSION["idAdmin"];
    $admin =  $_SESSION["admin"];
   
}else{
    die("Admin deconnecter");
}  

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
    if ($currentPassword === $dbPassword) {
        // Check if new passwords match
        if ($newPassword === $confirmNewPassword) {
            // Update password in database (you should hash it in the future)
            $sql = "UPDATE utilisateur SET motdepasse = ? WHERE idUtilisateur = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $newPassword, $userId);
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


<!-- Page content -->
<div class="page">
    <div class="top">
        <h2>Profile Administrateur</h2>
        <a href="infoPerso.php">
                <img src="../icons/adminIcon.png" alt="Admin Profile Picture">
            </a>    
    </div>
    
    <div class="content">
        <div class="admin-profile">
            <?php
                     $sql = "SELECT * FROM utilisateur u ,admin a where u.idUtilisateur=a.idUtilisateur and a.idAdmin=?; ";
                     $stmt = $conn->prepare($sql);
                     $stmt->bind_param("i", $id);
                     $stmt->execute();
                     $result = $stmt->get_result();
                     $row = $result->fetch_assoc();
                    ?>
            <form method="post" action="">
            <input type="hidden" name="user_id" value="<?php echo $row['idUtilisateur']; ?>">
            <div class="form-group">
                     <label style="color:red; font-weight:600; font-size:20px;" for="current-password">Changer Votre Mot de Passe</label>
                </div>
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
