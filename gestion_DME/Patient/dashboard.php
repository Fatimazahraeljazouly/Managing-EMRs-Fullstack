<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styleMedcin.css">
</head>
<body>
<?php 
include ("../includs/db.php");
session_start();

if (isset($_SESSION["idPt"])) {
    $idPt =  $_SESSION["idPt"];
   
}

    // Modifiez la requête SQL pour inclure la condition sur idSec
    $sql = "SELECT u.nom as nom,u.prenom as prenom FROM utilisateur u ,patient p where u.idUtilisateur=p.idUtilisateur and p.idPt=?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPt);
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
            <li><div><img src="../icons/listUser.png" alt=""><a href="infomedical.php">Mon DM</a></div></li>
            <li><div><img src="../icons/updateUser.png" alt=""><a href="seeCNS.php">Mes Consultations</a></div></li>
            <li><div><img src="../icons/supprimeUser.png" alt=""><a href="rdv.php">Demander RDV</a></div></li>
            <li><div><img src="../icons/rdvicon.png" alt=""><a href="profil.php">Mon Profile</a></div></li>
            <li style="padding-top:4px !important; " ><div><img src="../icons/deconnexion.png" alt=""><a href="patientLogin.php">Se Deconnecter</a></div></li>
        </ul>
    </div>
</body>
</html>
