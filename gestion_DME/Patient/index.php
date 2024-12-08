<?php 
include 'dashboard.php';
include '../includs/db.php';
if (isset($_SESSION["idPt"]) && isset($_SESSION["patinet"])) {
    $idPt =  $_SESSION["idPt"];

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Patient</title>
    <link rel="stylesheet" href="../assets/css/stylePatient.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="page">
    <div class="top">
    <h2>Accueil</h2>
            <a href="infosPerso.php">
                <img  src="../icons/patientIcon.png" alt="patient Profile Picture">
            </a>

    </div>
    <div class="content">
            <div class="welcome-container">
                <h3 class="welcome-message">Bienvenue <?php echo  $_SESSION["patinet"]; ?>,</h3>
                <p class="welcome-description">Vous pouvez consulter dossier medical et vos information Medicaux depuis ce tableau de bord.</p>
            </div>
            <div class="stats">
                <div class="stat-item">
                    <h4>Nombre de Consultation</h4>
                    <?php 
                     if (isset($_SESSION["idPt"])) {
                        $idPt =  $_SESSION["idPt"];
                       
                    }
                        $sql = "SELECT COUNT(*) as cs FROM consultation where idPt=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $idPt);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                    ?>
                    <p><?php echo $row["cs"]; ?></p>
                </div>
                <div class="stat-item">
                    <?php 
                        $sql = "SELECT COUNT(*) as rdv FROM rendezvous where idPt=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $idPt);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row2 = $result->fetch_assoc();
                    ?>
                    <h4>Rendez-vous Aujourd'hui</h4>
                    <p><?php echo $row2["rdv"]; ?></p>
                </div>
               
            </div>
            <!-- Dossiers Médicaux Électroniques -->
            <div class="dme-table">
            <div class="welcome-container">
            <p class="welcome-description">Les 4 dernières consultations</p>
    
            </div>                
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID Consultation</th>
                            <th>Date de Consultation</th>
                            <th>Notes</th>
                            <th>Prescriptions</th>
                            <th>Poids(Kg)</th>
                            <th>Taille(m)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
$sql = "SELECT c.id, c.DATE, c.notes, i.prescriptions, i.poids, i.taille 
        FROM informationsmedicale i 
        JOIN consultation c ON i.idConsultation = c.id 
        WHERE c.idPt = ? 
        ORDER BY c.DATE DESC limit 4;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idPt);
$stmt->execute();
$result = $stmt->get_result();
$var = 1;  // Initialisez $var à 1 ou à tout autre valeur de départ souhaitée

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td style='background-color: #666; color:white;'>" . htmlspecialchars($var) . "</td>";  // Ajoutez les guillemets autour de la variable
    echo "<td data-label='ID Consultation'>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td data-label='Date de Consultation'>" . htmlspecialchars($row['DATE']) . "</td>";
    echo "<td data-label='Notes'>" . htmlspecialchars($row['notes']) . "</td>";
    echo "<td data-label='Prescriptions'>" . htmlspecialchars($row['prescriptions']) . "</td>";
    echo "<td data-label='Poids(Kg)'>" . htmlspecialchars($row['poids']) . "</td>";
    echo "<td data-label='Taille(m)'>" . htmlspecialchars($row['taille']) . "</td>";
    echo "</tr>";

    $var++;  // Incrémentez la variable pour le compteur
}
?>

                    </tbody>
                </table>
            </div>
          
        </div>
    <?php include 'footer.php' ?>
</div>
</body>
</html>
