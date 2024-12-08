<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php 
include ("../includs/db.php");
session_start();
if (isset($_SESSION['admin']) && isset(  $_SESSION['idAdmin'] )) {
    $id =  $_SESSION["idAdmin"];
    $admin =  $_SESSION["admin"];
   
}else{
    die("Admin deconnecter");
}

                    // Requête SQL pour récupérer les utilisateurs
                    $sql = "SELECT u.nom,u.prenom FROM utilisateur u ,admin a where u.idUtilisateur=a.idUtilisateur and a.idAdmin=?; ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    
                    ?>
    <div class="dashboard">
        <ul>
            <li><a id="dash" href="index.php" style="text-align: center; background-color:rgb(63, 98, 133); color: rgb(4, 38, 75);"><?php echo htmlspecialchars($row['nom']); echo " " ;echo htmlspecialchars($row['prenom']);?></a></li>
            <li><div><img src="../icons/infoPerso.png" alt=""><a href="infoPerso.php">Infos Personnelles</a></div></li>
            <li><div><img src="../icons/listUser.png" alt=""><a href="listeUsers.php">Liste Utilisateurs</a></div></li>
            <li><div><img src="../icons/addUser.png" alt=""><a href="addUser.php">Ajouter Utilisateur</a></div></li>
            <li><div><img src="../icons/updateUser.png" alt=""><a href="editUser.php">Modifier Utilisateur</a></div></li>
            <li><div><img src="../icons/supprimeUser.png" alt=""><a href="deleteUser.php">Supprimer Utilisateur</a></div></li>
            <li><div><img src="../icons/profiladmin.png" alt=""><a href="profilAdmin.php">mon Administrateur</a></div></li>
            <li><div><img src="../icons/deconnexion.png" alt=""><a href="adminLogin.php">Se Deconnecter</a></div></li>
        </ul>
    </div>
</body>
</html>
