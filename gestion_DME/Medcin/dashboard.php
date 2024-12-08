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

if (isset($_SESSION["idMd"])) {
    $idMd = $_SESSION["idMd"];
}
    // Modifiez la requête SQL pour inclure la condition sur idSec
    $sql = "SELECT u.nom,u.prenom FROM utilisateur u ,medecin a where u.idUtilisateur=a.idUtilisateur and a.idMd = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idMd);
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
            <li><div><img src="../icons/infoPerso.png" alt=""><a href="infosPerso.php">Infos Personnelles</a></div></li>
            <li><div><img src="../icons/creedme.png" alt=""><a href="creeDME.php">Creer DME</a></div></li>
            <li><div><img src="../icons/consulterdme.png" alt=""><a href="consulterDME.php">Consulter DME</a></div></li>
            <li><div><img src="../icons/seedme.png" alt=""><a href="seeCNS.php">Consultations</a></div></li>
            <li><div><img src="../icons/addcs.png" alt=""><a href="ajouterCNS.php">Ajouter Consultation</a></div></li>
            <li><div><img src="../icons/rdvicon.png" alt=""><a href="gereRDV.php">Gerer RDVs</a></div></li>
            <li><div><img src="../icons/monprofil.png" alt=""><a href="profile.php">Mon profile</a></div></li>
            <li style="padding-top:4px !important; " ><div><img src="../icons/deconnexion.png" alt=""><a href="medcinLogin.php"  >Se D econnecter</a></div></li>
        </ul>
    </div>
</body>
</html>
