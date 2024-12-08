
<?php 
include 'dashboard.php';
    include '../includs/db.php';
    ini_set('display_errors', 1);
    $update_msg = '';
if (isset($_SESSION['admin']) && isset(  $_SESSION['idAdmin'] )) {
    $id =  $_SESSION["idAdmin"];
    $admin =  $_SESSION["admin"];
   
}else{
    die("Admin deconnecter");
}
             
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
        $user_id = $_POST['user_id'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $sex = $_POST['sex'];
        $phone = $_POST['phone'];
        $CIN = $_POST['CIN'];

        $stm = $conn->prepare("UPDATE utilisateur SET nom=?, prenom=?, email=?, sexe=?, telephone=?, cin=? WHERE idUtilisateur=?;");
        $stm->bind_param("ssssssi", $lastName, $firstName, $email, $sex, $phone, $CIN, $user_id);

        if ($stm->execute()) {
            $update_msg = "Informations  mises à jour avec succès.";
        } else {
            $update_msg = "Erreur lors de la mise à jour des informations utilisateur.";
        }
        $stm->close();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations Personnel</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Page content -->
    <div class="page">
        <div class="top">
            <h2>infos personnelles</h2>
            <a href="infoPerso.php">
                <img src="../icons/adminIcon.png" alt="Admin Profile Picture">
            </a>    
        </div>
        
        <div class="content">
            <div class="personal-info">
                <h2>Informations Personnelles</h2>
                <form method="POST">
                   
                     <?php 
                    // Requête SQL pour récupérer les utilisateurs
                    $sql = "SELECT * FROM utilisateur u ,admin a where u.idUtilisateur=a.idUtilisateur and a.idAdmin=?; ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    
                    ?>
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['idUtilisateur']); ?>">
                    <div class="form-group">
                        <label for="firstName">Nom d'utilisateur:</label>
                        <input type="text" id="firstName" name="firstName" value=<?php  echo htmlspecialchars($row['username']);?> >
                    </div>
                    <div class="form-group">
                        <label for="firstName">Prénom:</label>
                        <input type="text" id="firstName" name="firstName" value=<?php  echo htmlspecialchars($row['prenom']);?> >
                    </div>
                    <div class="form-group">
                        <label for="lastName">Nom:</label>
                        <input type="text" id="lastName" name="lastName" value=<?php  echo htmlspecialchars($row['nom']);?>>
                    </div>
                    <div class="form-group">
                        <label for="sex">Sexe:</label>
                        <input type="text" id="sex" name="sex" value=<?php  echo htmlspecialchars($row['sexe']);?>>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value=<?php  echo htmlspecialchars($row['email']);?>>
                    </div>
                    <div class="form-group">
                        <label for="phone">Télé:</label>
                        <input type="tel" id="phone" name="phone" value=<?php  echo htmlspecialchars($row['telephone']);?>>
                    </div>
                    <div class="form-group">
                        <label for="CIN">CIN:</label>
                        <input type="text" id="CIN" name="CIN" value=<?php  echo htmlspecialchars($row['cin']);?>>
                    </div>
                    <div class="form-group">
                        <label for="role">Rôle:</label>
                        <select id="role" name="role" >
                            <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; echo 'disabled'; ?>>Administrateur</option>
                            <option value="infirmier" <?php if ($row['role'] == 'infirmier') echo 'selected'; echo 'disabled'; ?>>Infirmier</option>
                            <option value="medecin" <?php if ($row['role'] == 'medecin') echo 'selected'; echo 'disabled';?>>Médecin</option>
                            <option value="secretaire" <?php if ($row['role'] == 'secretaire') echo 'selected'; echo 'disabled';?>>Secrétaire</option>
                        </select>
                    </div>
                    <button type="submit" name="update" >Modifier Information</button>
                </form>
            </div>
             
            <?php if (isset($update_msg)): ?>
                <p><?php echo $update_msg; ?></p>
            <?php endif; ?>

        </div>
        
       <?php include 'footer.php' ?>
    </div>
</body>
</html>
