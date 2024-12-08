
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
     
</head>
<body>

    <div class="page">
        <div class="top">
            <h2>Mon Dossier Medical</h2>
            <a href="infosPerso.php">
                <img src="../icons/patientIcon.png" alt="Admin Profile Picture">
            </a>
        </div>

        <div class="content">
       
            
             <?php 
                include 'dashboard.php';
                include '../includs/db.php';
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                if (isset($_SESSION["idPt"])) {
                    $idPt =  $_SESSION["idPt"];
                
                }
             
                                $stmt = $conn->prepare("SELECT 
                        p.allergies,
                        p.antecedents, 
                        p.idPt,
                        d.id AS dossier_id, 
                        d.dateCreation,
                        d.observations, 
                        d.diagnostics, 
                        d.prescriptions,
                        i.poids, 
                        i.taille, 
                        i.tensionArterielle, 
                        i.frequenceCardiaque,
                        c.date AS consultation_date, 
                        c.notes,
                        c.id AS idCons
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
                    LIMIT 1;");
                        $stmt->bind_param("i", $idPt);
                     $stmt->execute();
                     $result = $stmt->get_result();
                     $user = $result->fetch_assoc();
             ?>
             
            <?php if (isset($user) && $user): ?>
            <div class="edit-user-form">
                <h2>les informations de DME</h2>
                <form action="" method="post">
                    <input type="hidden" name="idPt" value="<?php echo htmlspecialchars($user['idPt']); ?>">
                    <div class="form-group">
                            <label for="dateCreation">Date de Creation de DME:</label>
                            <input type="text" id="dateCreation" name="dateCreation" value="<?php echo htmlspecialchars($user['dateCreation']); ?>" readonly>
                        </div>
                   
                     <!-- Informations Médicales -->
                     <div class="mesures-physiques"style="background-color:white; padding:10px; border-radius:8px; margin-bottom:9px;">
                        <h3>les mesures physiques</h3>
                        <div class="form-group">
                            <label for="poids">Poids(en kg):</label>
                            <input type="text" id="poids" name="poids" value="<?php echo htmlspecialchars($user['poids']); echo "Kg"; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="taille">taille(en m):</label>
                            <input type="text" id="taille" name="taille" value="<?php echo htmlspecialchars($user['taille']); echo "m";?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tensionArterielle">Tension Arterielle(en mmHg):</label>
                            <input type="text" id="tensionArterielle" name="tensionArterielle" value="<?php echo htmlspecialchars($user['tensionArterielle']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="frequenceCardiaque">Frequence Cardiaque(en pm):</label>
                            <input type="text" id="frequenceCardiaque" name="frequenceCardiaque" value="<?php echo htmlspecialchars($user['frequenceCardiaque']); echo"bpm";?>" readonly>
                        </div>
                    </div>
                    <!-- Informations Médicales -->
                    <div class="medical-info" style="background-color:white; padding:10px; border-radius:8px; margin-bottom:9px;">
                        <h3>Informations Médicales</h3>
                        <div class="form-group">
                            <label for="allergies">Allergies:</label>
                            <textarea name="allergies" id="allergies" readonly><?php echo htmlspecialchars($user['allergies']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="antecedents">Antecedents:</label>
                            <textarea name="antecedents" id="antecedents" readonly><?php echo htmlspecialchars($user['antecedents']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="observations">Observations:</label>
                            <textarea name="observations" id="observations" readonly><?php echo htmlspecialchars($user['observations']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="diagnostics">Diagnostics:</label>
                            <textarea name="diagnostics" id="diagnostics" readonly><?php echo htmlspecialchars($user['diagnostics']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="prescriptions">Prescriptions:</label>
                            <textarea name="prescriptions" id="prescriptions" readonly><?php echo htmlspecialchars($user['prescriptions']); ?></textarea>
                        </div>

                        <?php 
                           $stmt = $conn->prepare("SELECT COUNT(*) as nbcns FROM consultation WHERE idPt = ?");
                           $stmt->bind_param("i", $idPt);
                           $stmt->execute();
                           $result = $stmt->get_result();
                           $row = $result->fetch_assoc(); // Correction ici : 'fetch_assoc()' au lieu de 'fetsh_assoc()'
                           $stmt->close();
                           
                        ?>
                        <div class="form-group">
                            <label for="nbcns">Nombre des Consultations:</label>
                            <input type="text" id="nbcns" name="nbcns" value="<?php echo htmlspecialchars($row['nbcns']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="notes">Note:</label>
                            <textarea id="notes" name="notes" readonly ><?php echo htmlspecialchars($user['notes']); ?></textarea>
                        </div>
                    </div>
                     
                </form>
                
                <?php if (!empty($update_message)): ?>
                    <p><?php echo $update_message; ?></p>
                <?php endif; ?>
            </div>
            <?php elseif (isset($update_message)): ?>
                <p><?php echo $update_message; ?></p>
            <?php endif; ?>
        </div>
        <?php include 'footer.php'; ?>

    </div>
</body>
</html>
