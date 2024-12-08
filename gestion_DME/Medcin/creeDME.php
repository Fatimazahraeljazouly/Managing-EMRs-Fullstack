<?php
include 'dashboard.php'; 
include '../includs/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$errmsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Récupération des données du formulaire
    $cin_patient = $_POST['CNIpt'];
    $cin_infermier = $_POST['cinif'];
    $antecedents = $_POST["antecedents"];
    $allergies = $_POST['allergies'];
    $observations = $_POST['observations'];
    $diagnostics = $_POST['diagnostics'];
    $prescriptions = $_POST['prescriptions'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $tensionart = $_POST['tensionart'];
    $frc = $_POST['frc'];
    $note = $_POST['note'];
    $date_creation = $_POST['datec'];

    // Récupération de l'ID du patient
    $stmt = $conn->prepare("SELECT p.idPt FROM utilisateur u, patient p WHERE p.idUtilisateur = u.idUtilisateur AND u.cin = ?");
    $stmt->bind_param("s", $cin_patient);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $idPt = $row["idPt"];
    } else {
        $_SESSION['alert_message'] = "Erreur : " . $stmt->error;
        $_SESSION['alert_type'] = "error";
    }
    $stmt->close();

    // Vérifier si un dossier médical existe déjà
    $stmt = $conn->prepare("SELECT id, dateCreation FROM dossiermedical WHERE idPt = ?");
    $stmt->bind_param("i", $idPt);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $dossier = $result->fetch_assoc();
            $dossier_id = $dossier['id'];
            $dossier_date = $dossier['dateCreation'];
            $_SESSION['alert_message'] = "Un dossier médical existe déjà pour ce patient (ID_Dossier : $dossier_id, Date de création : $dossier_date). ? <a href='creeDME.php' class='btn btn-cancel'>Annuler</a>";
            $_SESSION['alert_type'] = "warning";
        } else {
            // Création du dossier médical s'il n'existe pas
            createMedicalFile($conn, $date_creation, $observations, $diagnostics, $prescriptions, $idPt, $idMd, $idInfr, $note, $poids, $taille, $tensionart, $frc);
        }
    } else {
        $_SESSION['alert_message'] = "Erreur : " . $stmt->error;
        $_SESSION['alert_type'] = "error";
    }
    $stmt->close();

    // Gestion de la continuation ou de l'annulation
    if (isset($_GET['continue']) && $_GET['continue'] == 'yes') {
        echo '<pre>';
        echo 'GET Parameters:';
        print_r($_GET);
        echo '</pre>';
    
        // Assurez-vous que tous les paramètres nécessaires sont présents
        if (isset($_GET['datec'], $_GET['observations'], $_GET['diagnostics'], $_GET['prescriptions'], $_GET['poids'], $_GET['taille'], $_GET['tensionart'], $_GET['frc'], $_GET['cinif'])) {
            createMedicalFile(
                $conn,
                $_GET['datec'],
                $_GET['observations'],
                $_GET['diagnostics'],
                $_GET['prescriptions'],
                $idPt,
                $idMd,
                $idInfr,
                $_GET['note'],
                $_GET['poids'],
                $_GET['taille'],
                $_GET['tensionart'],
                $_GET['frc']
            );
        } else {
            $_SESSION['alert_message'] = "Erreur : Certains paramètres sont manquants.";
            $_SESSION['alert_type'] = "error";
        }
    }
    

    header("Location: creeDME.php");
    exit();
    $conn->close();
}

function createMedicalFile($conn, $date_creation, $observations, $diagnostics, $prescriptions, $idPt, $idMd, $idInfr, $note, $poids, $taille, $tensionart, $frc) {
    echo '<pre>';
    echo 'Creating medical file with:';
    print_r(compact('date_creation', 'observations', 'diagnostics', 'prescriptions', 'idPt', 'idMd', 'idInfr', 'note', 'poids', 'taille', 'tensionart', 'frc'));
    echo '</pre>';

    // Insertion dans consultation
    $stmt = $conn->prepare("INSERT INTO consultation (DATE, notes, idPt, idMd) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $date_creation, $note, $idPt, $idMd);
    if ($stmt->execute()) {
        $idconsultation = $stmt->insert_id;
        $stmt1 = $conn->prepare("INSERT INTO informationsmedicale (observations, diagnostics, prescriptions, poids, taille, tensionArterielle, frequenceCardiaque, idPt, idConsultation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("sssddsiii", $observations, $diagnostics, $prescriptions, $poids, $taille, $tensionart, $frc, $idPt, $idconsultation);
        if ($stmt1->execute()) {
            $stmt2 = $conn->prepare("INSERT INTO dossiermedical (dateCreation, observations, diagnostics, prescriptions, idPt, idMd, idInfr) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt2->bind_param("ssssiii", $date_creation, $observations, $diagnostics, $prescriptions, $idPt, $idMd, $idInfr);
            if ($stmt2->execute()) {
                $_SESSION['alert_message'] = "Dossier médical créé.";
                $_SESSION['alert_type'] = "success";
            } else {
                $_SESSION['alert_message'] = "Erreur : " . $stmt2->error;
                $_SESSION['alert_type'] = "error";
            }
        } else {
            $_SESSION['alert_message'] = "Erreur : " . $stmt1->error;
            $_SESSION['alert_type'] = "error";
        }
    } else {
        $_SESSION['alert_message'] = "Erreur : " . $stmt->error;
        $_SESSION['alert_type'] = "error";
    }
    $stmt->close();
}


// Affichage des messages d'alerte si présents
if (isset($_SESSION['alert_message'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            showAlert("' . $_SESSION['alert_message'] . '", "' . $_SESSION['alert_type'] . '");
        });
    </script>';
    unset($_SESSION['alert_message']);
    unset($_SESSION['alert_type']);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer DME</title>
    <link rel="stylesheet" href="../assets/css/styleMedcin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        function showAlert(message, type) {
            const alertContainer = document.getElementById('alert-container');
            alertContainer.innerHTML = `<div class="alert ${type}">${message}</div>`;
            setTimeout(() => {
                       alertContainer.innerHTML = '';
                 }, 5000); // 5000 ms = 5 secondes
        }
    </script>
</head>
<body>
<div id="alert-container" class="alert-container"></div>
<div class="page">
        <div class="top">
            <h2>Créer DME</h2>
            <a href="infosPerso.php">
                <img src="../icons/medcinIcon.png" alt="Médecin Profile Picture">
            </a>
        </div>
        
        <div class="content">
            <div class="add-user-form">
                <h2>Informations de DME</h2>
                <form action="" method="post">
                    <!-- Form Fields Here -->
                    <div class="form-group">
                        <label for="CNIpt">CNI Patient:</label>
                        <input type="text" id="CNIpt" name="CNIpt" required>
                    </div>
                    <div class="form-group">
                        <label for="antecedents">antécédents médicaux:</label>
                        <textarea name="antecedents" id="antecedents" required rows="4" cols="50" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="allergies">Allergies:</label>
                        <textarea name="allergies" id="allergies" required rows="4" cols="50" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="observations">Observations:</label>
                        <textarea name="observations" id="observations" required rows="4" cols="50" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="diagnostics">Diagnostics:</label>
                        <textarea name="diagnostics" id="diagnostics" required rows="4" cols="50" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="prescriptions">Prescriptions:</label>
                        <textarea name="prescriptions" id="prescriptions" required rows="4" cols="50" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Poids">Poids:</label>
                        <input type="number" id="Poids" name="poids" required>
                    </div>
                    <div class="form-group">
                        <label for="taille">Taille:</label>
                        <input type="number" id="taille" name="taille" required>
                    </div>
                    <div class="form-group">
                        <label for="tensionart">Tension Artérielle:</label>
                        <input type="text" id="tensionart" name="tensionart" required>
                    </div>
                    <div class="form-group">
                        <label for="frc">fréquence cardiaque:</label>
                        <input type="number" id="frc" name="frc" required>
                    </div>
                    <div class="form-group">
                        <label for="note">Note:</label>
                        <textarea name="note" id="note" required rows="4" cols="50" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="datec">Date de Creation:</label>
                        <input type="date" id="datec" name="datec" required>
                    </div>
                    <div class="form-group">
                        <label for="cinif">CIN d'infermier :</label>
                        <input type="text" id="cinin" name="cinif" required>
                    </div>
                    <button type="submit" name="add">Créer DME</button>
                </form>
            </div>
        </div>
        
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
