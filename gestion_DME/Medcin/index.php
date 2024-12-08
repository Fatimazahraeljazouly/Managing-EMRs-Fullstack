<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medecin</title>
    <link rel="stylesheet" href="../assets/css/styleMedcin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
</head>
<body>
    <?php
    include 'dashboard.php';
    include '../includs/db.php';
    if (!isset($_SESSION['username']) || !isset($_SESSION['idMd']) ) {
        die("Erreur : medecin non connecté.");
    } else {
        $username = $_SESSION['username'];
        $idMd = $_SESSION['idMd'];
    }
    ?>

    <div class="page">
        <div class="top">
            <h2>Espace Médecin</h2>
            <a href="infosPerso.php">
                <img src="../icons/medcinIcon.png" alt="medecin Profile Picture">
            </a>
        </div>        
        <div class="content">
            <div class="welcome-container">
                <h3 class="welcome-message">Bienvenue, <?php echo  $_SESSION['username']; ?></h3>
                <p class="welcome-description">Vous pouvez gérer les Rendez Vous, les patients et les DMEs depuis ce tableau de bord.</p>
            </div>
            <div class="stats">
                <div class="stat-item">
                    <h4>Nombre de Patients</h4>
                    <?php 
                       $sql = "SELECT COUNT(*) FROM patient p JOIN dossiermedical d ON p.idPt = d.idPt WHERE d.idMd = ?";
                       $stmt = $conn->prepare($sql);
                       $stmt->bind_param("i", $idMd);
                       $stmt->execute();
                       $result = $stmt->get_result();
                       $row = $result->fetch_row();
                       
                    ?>
                    <p><?php echo $row[0]; ?></p>
                </div>
                <div class="stat-item">
                    <?php 
                        $sql = "SELECT COUNT(*) FROM rendezvous where idMd=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $idMd);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row2 = $result->fetch_row();
                       
                    ?>
                    <h4>Rendez-vous Aujourd'hui</h4>
                    <p><?php echo $row2[0]; ?></p>
                </div>
                <div class="stat-item">
                    <?php 
                        $sql = "SELECT COUNT(*) AS count FROM consultation WHERE idMd = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $idMd);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row3 = $result->fetch_assoc();
                    ?>
                    <h4>Nombre de Consultations</h4>
                    <p><?php echo $row3['count']; ?></p>
                </div>
            </div>
            <!-- Dossiers Médicaux Électroniques -->
            <div class="dme-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID Dossier</th>
                            <th>Date de Création</th>
                            <th>Prescription</th>
                            <th>Nom du Patient</th>
                            <th>CIN</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT d.id, d.dateCreation, d.diagnostics,i.cin, CONCAT(i.nom, ' ', i.prenom) AS patient_name
                                FROM dossiermedical d, patient p,utilisateur i
                                where d.idPt=p.idPt And p.idUtilisateur =i.idUtilisateur
                              and d.idMd = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $idMd);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td data-label='ID Dossier'>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td data-label='Date de Création'>" . htmlspecialchars($row['dateCreation']) . "</td>";
                            echo "<td data-label='Diagnostics'>  " . htmlspecialchars($row['diagnostics']) . "</td>";
                            echo "<td data-label='Nom du Patient'>" . htmlspecialchars($row['patient_name']) . "</td>";
                            echo "<td data-label='CIN du Patient'>" . htmlspecialchars($row['cin']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
          
        </div>
          

        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
