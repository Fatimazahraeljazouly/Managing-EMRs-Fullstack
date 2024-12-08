

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir Consultations</title>
    <link rel="stylesheet" href="../assets/css/styleMedcin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
 
</head>
<body>
    <div class="page">
        <div class="top">
            <h2>Mes Consultations</h2>
            <a href="infosPerso.php">
                <img  src="../icons/patientIcon.png" alt="patient Profile Picture">
            </a>
        </div>
<?php
include 'dashboard.php';
include '../includs/db.php';
if (isset($_SESSION["idPt"]) && isset($_SESSION["patinet"])) {
    $idPt =  $_SESSION["idPt"];

}

?>
        <div class="content">
        <div class="welcome-container">
                <h3 class="welcome-message">Bienvenue <?php echo   $_SESSION["patinet"]; ?>,</h3>
                <p >Voici vos Consultations dans Notre clinique</p>
                </div>

            <!-- Affichage des consultations -->
            <div class="dme-table">
            <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID Consultation</th>
                            <th>Date de Consultation</th>
                            <th>Diagnostics</th>
                            <th>Prescriptions</th>
                            <th>Observations</th>
                            <th>Notes</th>
                            <th>Tension Arterielle</th>
                            <th>Frequence Cardiaque</th>
                            <th>Poids(Kg)</th>
                            <th>Taille(m)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                if (isset($_SESSION["idPt"])) {
                    $idPt =  $_SESSION["idPt"];
                
                }
             
                                $stmt = $conn->prepare("SELECT 
                        p.idPt,
                        d.observations, 
                        d.diagnostics, 
                        d.prescriptions,
                        i.poids, 
                        i.taille, 
                        i.tensionArterielle, 
                        i.frequenceCardiaque,
                        c.DATE , 
                        c.notes,
                        c.id AS idCons,
                        c.id as id
                    FROM 
                        patient p
                    JOIN 
                        dossiermedical d ON d.idPt = p.idPt 
                    JOIN 
                        informationsmedicale i ON i.idPt = p.idPt 
                    JOIN 
                        consultation c ON c.id = i.idConsultation
                    WHERE 
                        d.idPt = ?
                    ORDER BY 
                        c.date DESC 
                ;");
                     $stmt->bind_param("i", $idPt);
                     $stmt->execute();
                     $result = $stmt->get_result();
                     $var = 1;  // Initialisez $var à 1 ou à tout autre valeur de départ souhaitée

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style='background-color: #666; color:white;'>" . htmlspecialchars($var) . "</td>";  // Ajoutez les guillemets autour de la variable
                            echo "<td data-label='ID Consultation'>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td data-label='Date de Consultation'>" . htmlspecialchars($row['DATE']) . "</td>";
                            echo "<td data-label='Diagnostics'>" . htmlspecialchars($row['diagnostics']) . "</td>";
                            echo "<td data-label='Prescriptions'>" . htmlspecialchars($row['prescriptions']) . "</td>";
                            echo "<td data-label='Observations'>" . htmlspecialchars($row['observations']) . "</td>";
                            echo "<td data-label='Notes'>" . htmlspecialchars($row['notes']) . "</td>";
                            echo "<td data-label='Tension Arterielle(m)'>" . htmlspecialchars($row['tensionArterielle']) . "</td>";
                            echo "<td data-label='Frequence Cardiaque'>" . htmlspecialchars($row['frequenceCardiaque']) . "</td>";
                            echo "<td data-label='Poids(Kg)'>" . htmlspecialchars($row['poids']) . "</td>";
                            echo "<td data-label='Taille(m)'>" . htmlspecialchars($row['taille']) . "</td>";
                            echo "</tr>";

                            $var++;  // Incrémentez la variable pour le compteur
                        }
                         ?>
                </tbody>
            </table>                         

            </div>
          
             
            
              <!--   <div class="dme-table">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date Consultation</th>
                            <th>Notes</th>
                            <th>Taille</th>
                            <th>Poids</th>
                            <th>Tension Artérielle</th>
                            <th>Fréquence Cardiaque</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultations as $consultation): ?>
                            <tr>
                                <td  style="background-color: #666; color:white;"><?php echo ++$num; ?></td>
                                <td data-label='Date' ><?php echo htmlspecialchars($consultation['id']); ?></td>
                                <td data-label='Date' ><?php echo htmlspecialchars($consultation['date']); ?></td>
                                <td data-label='Notes' ><?php echo htmlspecialchars($consultation['']); ?></td>
                                <td data-label='Taille(m)' > <?php echo htmlspecialchars($consultation['taille']); ?></td>
                                <td data-label='Poids(Kg)'><?php echo htmlspecialchars($consultation['poids']); ?></td>
                                <td data-label='Tension Arterielle'><?php echo htmlspecialchars($consultation['tensionArterielle']); ?></td>
                                <td data-label='Frequence Cardiaque' ><?php echo htmlspecialchars($consultation['frequenceCardiaque']); ?></td>
                                <td data-label='Taille(m)' > <?php echo htmlspecialchars($consultation['taille']); ?></td>
                                <td data-label='Poids(Kg)'><?php echo htmlspecialchars($consultation['poids']); ?></td>
                                <td data-label='Tension Arterielle'><?php echo htmlspecialchars($consultation['tensionArterielle']); ?></td>
                                <td data-label='Frequence Cardiaque' ><?php echo htmlspecialchars($consultation['frequenceCardiaque']); ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div> -->
                
        </div>
        <?php include "footer.php" ?>
    </div>
</body>
</html>
