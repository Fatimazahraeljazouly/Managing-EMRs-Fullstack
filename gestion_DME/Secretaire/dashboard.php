<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
</head>
<body>
<?php 
include ("../includs/db.php");
session_start();

if (isset($_SESSION['idSec'])) {
    $idSec = $_SESSION['idSec'];}

    // Modifiez la requête SQL pour inclure la condition sur idSec
    $sql = "SELECT * FROM utilisateur u ,secretaire a where u.idUtilisateur=a.idUtilisateur and a.idSec = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idSec);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

/*   $sql = "SELECT * FROM utilisateur u ,secretaire a where u.idUtilisateur=a.idUtilisateur;";
$result = $conn->query($sql);
$row = $result->fetch_assoc(); */            
?>
    <div class="dashboard">
        <ul>
            <li><a id="dash" href="index.php" style="text-align: center; background-color:rgb(63, 98, 133); color: rgb(4, 38, 75);"><?php echo htmlspecialchars($row['nom']); echo " " ;echo htmlspecialchars($row['prenom']);?></a></li>
            <li><div><img src="../icons/infoPerso.png" alt=""><a href="infosPerso.php">Infos Personnel</a></div></li>
            <li><div><img src="../icons/listUser.png" alt=""><a href="listpatient.php">Liste Patients</a></div></li>
            <li><div><img src="../icons/addUser.png" alt=""><a href="addUser.php">Ajouter Patient</a></div></li>
            <li><div><img src="../icons/updateUser.png" alt=""><a href="editUser.php">Modifier Patient</a></div></li>
            <li><div><img src="../icons/supprimeUser.png" alt=""><a href="deleteUser.php">Supprimer Patient</a></div></li>
            <li><div><img src="../icons/profiladmin.png" alt=""><a href="profilsec.php">Mon Profile</a></div></li>
            <li><div><img src="../icons/rdvicon.png" alt=""><a href="gereRDV.php">Gerer RDVs</a></div></li>
            <li style="padding-top:4px !important; " ><div><img src="../icons/deconnexion.png" alt=""><a href="secretaireLogin.php">Se Deconnecter</a></div></li>
        </ul>
    </div>
</body>
</html>
