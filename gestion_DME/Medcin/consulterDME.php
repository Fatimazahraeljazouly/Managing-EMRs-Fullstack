<?php
include 'dashboard.php';
include '../includs/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$update_message = '';
if (!isset($_SESSION['username']) || !isset($_SESSION['idMd'])) {
    die("Erreur : médecin non connecté.");
} else {
    $username = $_SESSION['username'];
    $idMd = $_SESSION['idMd'];
}

/* if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['nom']) || isset($_POST['prenom']) || isset($_POST['cin']))) {
    $nome = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $cin = $_POST['cin'] ?? '';
    $nome_like = "%$nome%";
    $prenom_like = "%$prenom%";
    $cin_like = "%$cin%";
    
    // Requête SQL pour rechercher des utilisateurs correspondant aux critères et ajoutés par le secrétaire connecté
            $stmt = $conn->prepare("SELECT 
            u.idUtilisateur,
            u.nom AS utilisateur_nom,
            u.prenom AS utilisateur_prenom, 
            u.email, 
            u.telephone, 
            u.cin, 
            u.sexe,
            p.datenaissance, 
            p.adresse, 
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
            c.id 
        FROM 
            utilisateur u 
        JOIN 
            patient p ON p.idUtilisateur = u.idUtilisateur
        JOIN 
            dossiermedical d ON d.idPt = p.idPt 
        JOIN 
            informationsmedicale i ON i.idPt = p.idPt 
        JOIN 
            consultation c ON c.idPt =i.idConsultation
        WHERE 
            d.idMd = ? 
            AND u.nom like ? 
            AND u.prenom like ?
            AND u.cin like ?
        ORDER BY 
            c.date DESC 
        LIMIT 1;

    ");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("isss", $idMd, $nome_like, $prenom_like, $cin_like);
    $stmt->execute();
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête : " . $stmt->error);
    }    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
   

    if (!$user) {
        $update_message = "Aucun Dossier trouvé pour ce Patient.";
    }else{
        $idPt = $user["idPt"];
        $idcons=$user["id"];
    }
    $stmt->close();
} */

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['nom']) || isset($_POST['prenom']) || isset($_POST['cin']))) {
    $nome = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $cin = $_POST['cin'] ?? '';
    $nome_like = "%$nome%";
    $prenom_like = "%$prenom%";
    $cin_like = "%$cin%"; 
    // Requête SQL pour rechercher des utilisateurs correspondant aux critères
    $stmt = $conn->prepare("
        SELECT 
            u.idUtilisateur,
            u.nom AS utilisateur_nom,
            u.prenom AS utilisateur_prenom, 
            u.email, 
            u.telephone, 
            u.cin, 
            u.sexe,
            p.datenaissance, 
            p.adresse, 
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
            c.id 
        FROM 
            utilisateur u 
        JOIN 
            patient p ON p.idUtilisateur = u.idUtilisateur
        JOIN 
            dossiermedical d ON d.idPt = p.idPt 
        JOIN 
            informationsmedicale i ON i.idPt = p.idPt 
        JOIN 
            consultation c ON c.idPt = i.idPt
        WHERE 
            u.nom LIKE ? 
            AND u.prenom LIKE ?
            AND u.cin LIKE ?
        ORDER BY 
            c.date DESC 
        LIMIT 1
    ");

    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param("sss", $nome_like, $prenom_like, $cin_like);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if (!$user) {
        $update_message = "Aucun dossier trouvé pour ce patient.";
    } else {
        $idPt = $user["idPt"];
        $idcons = $user["id"];
    }
    $stmt->close();
}

// Fonction pour mettre à jour les informations de l'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $idPt = $_POST['idPt'];
    $dateCreation=$_POST["dateCreation"];
    $poids=$_POST["poids"];//decimal
    $taille=$_POST["taille"];//decimal
    $tensionArterielle=$_POST["tensionArterielle"];
    $frequenceCardiaque=$_POST["frequenceCardiaque"];//int
    $allergies=$_POST["allergies"];
    $antecedents=$_POST["antecedents"];
    $observations=$_POST["observations"];
    $diagnostics=$_POST["diagnostics"];
    $prescriptions=$_POST["prescriptions"];
    $notes=$_POST["notes"];



    // Nettoyer et convertir les valeurs décimales
    $poids_cleaned = preg_replace('/[^0-9.]/', '', $poids);
    $taille_cleaned = preg_replace('/[^0-9.]/', '', $taille);

    $poids_decimal = floatval($poids_cleaned);
    $taille_decimal = floatval($taille_cleaned);

    // Nettoyer et convertir la fréquence cardiaque en entier
    $frequenceCardiaque_cleaned = preg_replace('/[^0-9]/', '', $frequenceCardiaque);
    $frequenceCardiaque_int = intval($frequenceCardiaque_cleaned);
    // Préparation de la requête SQL pour la mise à jour de l'utilisateur
if($user){
    $stmt = $conn->prepare("UPDATE dossiermedical SET dateCreation = ?, observations = ?, diagnostics = ?, prescriptions = ? WHERE idPt = ? and idMd=?");
    if ($stmt === false) {

        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("ssssii", $dateCreation, $observations, $diagnostics, $prescriptions, $idPt, $idMd);
    
    if ($stmt->execute()) {
        // Préparation de la requête SQL pour la mise à jour du patient
        $stmt = $conn->prepare("UPDATE patient SET allergies=? , antecedents =? WHERE idPt = ?");
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }
        $stmt->bind_param("ssi", $allergies, $antecedents,$idPt);

        if ($stmt->execute()) {
            // Préparation de la requête SQL pour la mise à jour de la taille et du
            // poids du patient
            $stmt = $conn->prepare("UPDATE informationsmedicale SET taille = ?, poids = ? ,observations=?, diagnostics=?,prescriptions=?, tensionArterielle=? ,frequenceCardiaque=? WHERE idPt=?  ");
            if ($stmt === false) {
                die("Erreur de préparation de la requête : " . $conn->error);
            }
            $stmt->bind_param("ddssssii", $taille_decimal, $poids_decimal,$observations,$diagnostics,$prescriptions,$tensionArterielle,$frequenceCardiaque_int,$idPt);
            if ($stmt->execute()) {
                $stmt = $conn->prepare("UPDATE consultation SET notes = ? WHERE id=?  ");
                if ($stmt === false) {
                    die("Erreur de préparation de la requête : " . $conn->error);
                }
                $stmt->bind_param("si", $notes, $idcons);
                if ($stmt->execute()) {
                $update_message =  "Mise à jour réussie !";
                }
                } else {
                    $update_message =  "Erreur de mise à jour : " ;
                    }                    
        } else {
            $update_message = "Erreur de mise à jour du patient : " . $stmt->error;
        }
    } else {
        $update_message = "Erreur de mise à jour de l'utilisateur : " . $stmt->error;
    }

    $stmt->close();
}
header("Location: consulterDME.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter un Dossier Medical </title>
    <link rel="stylesheet" href="../assets/css/styleMedcin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
     
</head>
<body>

    <div class="page">
        <div class="top">
            <h2>Consulter un Dossier Medical</h2>
            <a href="infosPerso.php">
                <img src="../icons/medcinIcon.png" alt="Admin Profile Picture">
            </a>
        </div>

        <div class="content">
            <!-- Formulaire de recherche -->
            <div class="search-user-form">
                <h2>Rechercher Par Patient</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="cin">CIN:</label>
                        <input type="text" id="cin" name="cin">
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom">
                    </div>
                    <button type="submit">Rechercher</button>
                </form>
            </div>
            
            <!-- Formulaire de modification si l'utilisateur est trouvé -->
            <?php if (isset($user) && $user): ?>
            <div class="edit-user-form">
                <h2>Modifier les informations de DME</h2>
                <form action="" method="post">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['idUtilisateur']); ?>">
                    <input type="hidden" name="idPt" value="<?php echo htmlspecialchars($user['idPt']); ?>">
                    <div class="form-group">
                            <label for="dateCreation">Date de Creation de DME:</label>
                            <input type="text" id="dateCreation" name="dateCreation" value="<?php echo htmlspecialchars($user['dateCreation']); ?>" >
                        </div>
                    <!-- Informations Personnelles -->
                    <div class="personal-info">
                        <h3>Informations Personnelles</h3>
                        <div class="form-group">
                            <label for="nome">Nom:</label>
                            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['utilisateur_nom']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom:</label>
                            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['utilisateur_prenom']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="cin">CIN:</label>
                            <input type="text" id="cin" name="cin" value="<?php echo htmlspecialchars($user['cin']);  ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone:</label>
                            <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['telephone']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="datenaissance">Date de Naissance:</label>
                            <input type="date" id="datenaissance" name="datenaissance" value="<?php echo htmlspecialchars($user['datenaissance']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="addresse">Adresse:</label>
                            <input type="text" id="addresse" name="addresse" value="<?php echo htmlspecialchars($user['adresse']);  ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="sexe">Sexe:</label>
                            <select id="sexe" name="sexe" required>
                                <option value="m" <?php if ($user['sexe'] == 'm') echo 'selected';echo 'disabled' ?>>Masculin</option>
                                <option value="f" <?php if ($user['sexe'] == 'f') echo 'selected'; echo 'disabled'?>>Féminin</option>
                            </select>
                        </div>
                        

                    </div>
                     <!-- Informations Médicales -->
                     <div class="mesures-physiques"style="background-color:white; padding:10px; border-radius:8px; margin-bottom:9px;">
                        <h3>les mesures physiques</h3>
                        <div class="form-group">
                            <label for="poids">Poids(en kg):</label>
                            <input type="text" id="poids" name="poids" value="<?php echo htmlspecialchars($user['poids']); echo "Kg"; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="taille">taille(en m):</label>
                            <input type="text" id="taille" name="taille" value="<?php echo htmlspecialchars($user['taille']); echo "m";?>" >
                        </div>
                        <div class="form-group">
                            <label for="tensionArterielle">Tension Arterielle(en mmHg):</label>
                            <input type="text" id="tensionArterielle" name="tensionArterielle" value="<?php echo htmlspecialchars($user['tensionArterielle']); ?>" >
                        </div>
                        <div class="form-group">
                            <label for="frequenceCardiaque">Frequence Cardiaque(en pm):</label>
                            <input type="text" id="frequenceCardiaque" name="frequenceCardiaque" value="<?php echo htmlspecialchars($user['frequenceCardiaque']); echo"bpm";?>" >
                        </div>
                    </div>
                    <!-- Informations Médicales -->
                    <div class="medical-info" style="background-color:white; padding:10px; border-radius:8px; margin-bottom:9px;">
                        <h3>Informations Médicales</h3>
                        <div class="form-group">
                            <label for="allergies">Allergies:</label>
                            <input type="text" id="allergies" name="allergies" value="<?php echo htmlspecialchars($user['allergies']); ?>" >
                        </div>
                        <div class="form-group">
                            <label for="antecedents">Antecedents:</label>
                            <input type="text" id="antecedents" name="antecedents" value="<?php echo htmlspecialchars($user['antecedents']); ?>" >
                        </div>
                        <div class="form-group">
                            <label for="observations">Observations:</label>
                            <input type="text" id="observations" name="observations" value="<?php echo htmlspecialchars($user['observations']); ?>" >
                        </div>
                        <div class="form-group">
                            <label for="diagnostics">Diagnostics:</label>
                            <input type="text" id="diagnostics" name="diagnostics" value="<?php echo htmlspecialchars($user['diagnostics']); ?>" >
                        </div>
                        <div class="form-group">
                            <label for="prescriptions">Prescriptions:</label>
                            <input type="text" id="prescriptions" name="prescriptions" value="<?php echo htmlspecialchars($user['prescriptions']); ?>" >
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
                            <textarea id="notes" name="notes" ><?php echo htmlspecialchars($user['notes']); ?></textarea>
                        </div>
                    </div>
                     
                    <button type="submit" name="update">Mettre à jour</button>
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
