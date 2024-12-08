<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Secrétaire</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
</head>
<body>
    <?php
    include 'dashboard.php';
    include '../includs/db.php';
    if (!isset($_SESSION['idSec'])) {
        die("Erreur : Secrétaire non connecté.");
    }
    ?>

    <div class="page">
      <!--   <div class="top">
            <h2>Tableau de Bord Secrétaire</h2>
            <a href="infosPerso.php">
                <img  src="../icons/secritaireIcon.png" alt="Admin Profile Picture">
            </a>
        </div> -->
<?php include ("top.php"); ?>
        <div class="content">
            <div class="welcome-container">
            <h3 class="welcome-message">Bienvenue, <?php echo  $_SESSION['username'] ; ?></h3>
                <p class="welcome-description">Vous pouvez gérer les Rendez Vous et les patients depuis ce tableau de bord.</p>
            </div>

            <!-- Section des alertes -->
            <div class="notifications">
                <h3>Alertes et Notifications</h3>
                <p>Pas d'alertes pour le moment.</p>
            </div>

            <!-- Statistiques -->
            <div class="stats">
                <div class="stat-item">
                    <h4>Nombre de Patients</h4>
                    <?php 
                    $sql="";
                    $sql = "SELECT COUNT(*) FROM patient";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_row($result);
                    ?>
                    <p><?php echo $row[0]; ?></p>
                </div>
                <?php 
                    $sql="";
                    $sql = "SELECT COUNT(*) FROM rendezvous";
                    $result = mysqli_query($conn, $sql);
                    $row2 = mysqli_fetch_row($result);
                    ?>
                <div class="stat-item">
                    <h4>Rendez-vous Aujourd'hui</h4>
                    <p><?php echo $row2[0]; ?></p>
                </div>
            </div>

           

            <!-- Actualités -->
            <div class="news">
                <h3>Actualités</h3>
                <ul>
                    <li><a href="#">Formation sur la nouvelle fonctionnalité d'ajout de patients.</a></li>
                </ul>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
