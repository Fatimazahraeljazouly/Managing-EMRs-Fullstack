<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'dashboard.php';
    include '../includs/db.php'
?>

<div class="page">
        <div class="top">
            <h2>Espace Administrateur</h2>
            <a href="infoPerso.php">
                <img src="../icons/adminIcon.png" alt="Admin Profile Picture">
            </a>        
        </div>
        <div class="welcome">
            <?php 
            // Requête SQL pour 
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
            
            <h3>bienvenue, <?php echo $row['nom']?> <?php echo $row['prenom'] ?>!</h3>
        </div>
        <div class="statistics" >
            <div class="all-Users">
                <img src="../icons/secritaireIcon.png" alt="">
                <?php 
            // Requête SQL pour 
            $sql = "SELECT count(*) as secTotal from utilisateur where role='secretaire';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $nbSec= $row ['secTotal']
            ?>
            <h3>(<?php echo $nbSec ?>) Secrétaire</h3>
            </div>
            <div class="patients">
                <img src="../icons/patientIcon.png" alt="">
                <?php 
            // Requête SQL pour 
            $sql = "SELECT count(*) as ptTotal from utilisateur u,patient p where u.idUtilisateur=p.idUtilisateur;";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $nbPt= $row ['ptTotal']
            ?>
                <h3>(<?php echo $nbPt; ?>) Patient</h3>
            </div>
            <div class="Medcin-number">
                    <img src="../icons/medcinIcon.png" alt="">
                    <?php 
            // Requête SQL pour 
            $sql = "SELECT count(*) as medTotal from utilisateur u , medecin m where u.idUtilisateur=m.idUtilisateur;";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $nbmed= $row ['medTotal'] ;
            ?>
                    <h3>(<?php echo $nbmed ?>) Medcin</h3>
            </div>
            <div class="infermier-number">
                <img src="../icons/infermierIcon.png" alt="">
                <?php 
            // Requête SQL pour 
            $sql = "SELECT count(*) as infTotal from infirmier i,utilisateur u where i.idUtilisateur=u.idUtilisateur;";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $nbinf= $row ['infTotal'] ;
            ?>    
                <h3> (<?php echo $nbinf ?>) Infirmier</h3>
            </div>
            <div class="secretaire-number">
                <img src="../icons/userIcon.png" alt="">
                <?php 
            // Requête SQL pour 
            $sql = "SELECT count(*) as userTotal from utilisateur ;";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $nbusers= $row ['userTotal']-1 ;//-1 pour un admin 
            ?>  
                <h3>(<?php echo $nbusers ?>) Utilisateur</h3>
            </div>
        </div>
        <?php include 'footer.php' ?>

    </div>
    
</body>
</html>