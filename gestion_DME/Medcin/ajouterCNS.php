<?php
include 'dashboard.php';
include '../includs/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Récupération et validation des données du formulaire
    $cin_patient = trim($_POST['CNIpt']);
    $allergies = trim($_POST['allergies']);
    $observations = trim($_POST['observations']);
    $diagnostics = trim($_POST['diagnostics']);
    $prescriptions = trim($_POST['prescriptions']);
    $taille = (float)$_POST['taille'];
    $poids = (float)$_POST['poids'];
    $tensionart = trim($_POST['tensionart']);
    $frc = (int)$_POST['frc'];
    $note = trim($_POST['note']);
    $date_creation = $_POST['datec'];

    // Vérification de l'ID du médecin dans la session
    if (isset($_SESSION['idMd'])) {
        $idMd = $_SESSION['idMd'];
    } else {
        $_SESSION['errmsg'] = "Vous n'êtes pas connecté !";
        $_SESSION['alert_type'] = "error";
        header("Location: ajouterCNS.php");
        exit();
    }

    // Rechercher l'ID du patient
    $stmt = $conn->prepare("SELECT p.idPt FROM utilisateur u, patient p WHERE p.idUtilisateur = u.idUtilisateur AND u.cin = ?");
    $stmt->bind_param("s", $cin_patient);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            $_SESSION['errmsg'] = "Le patient n'existe pas !";
            $_SESSION['alert_type'] = "error";
        } else {
            $idPt = $row["idPt"];
            $stmt->close();

            // Insertion de la consultation
            $stmt = $conn->prepare("INSERT INTO consultation (DATE, notes, idPt, idMd) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $date_creation, $note, $idPt, $idMd);

            if ($stmt->execute()) {
                $idconsultation = $stmt->insert_id;

                // Insertion des informations médicales
                $stmt1 = $conn->prepare("INSERT INTO informationsmedicale (observations, diagnostics, prescriptions, poids, taille, tensionArterielle, frequenceCardiaque, idPt, idConsultation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt1->bind_param("sssddsiii", $observations, $diagnostics, $prescriptions, $poids, $taille, $tensionart, $frc, $idPt, $idconsultation);

                if ($stmt1->execute()) {
                    $iDinfoMedical = $stmt1->insert_id;

                    // Mise à jour de la consultation avec l'ID des informations médicales
                    $stmt2 = $conn->prepare("UPDATE consultation SET idInformationsMedicale = ? WHERE id = ?");
                    $stmt2->bind_param("ii", $iDinfoMedical, $idconsultation);

                    if ($stmt2->execute()) {
                        $stmt3 = $conn->prepare("UPDATE dossiermedical SET observations = ?, diagnostics =?,prescriptions=? WHERE idPt = ? and idMd=?");
                        $stmt3->bind_param("sssii", $observations, $diagnostics, $prescriptions,$idPt,$idMd);
                        if($stmt3->execute()){
                            $_SESSION['errmsg'] = "La consultation a été ajoutée avec succès !";
                            $_SESSION['alert_type'] = "success";
                        }else{
                            $_SESSION['errmsg'] = "Une erreur est survenue lors de la mise à jour de DME !";
                            $_SESSION['alert_type'] = "error";
                        }
                        $stmt3->close();
                        $_SESSION['errmsg'] = "La consultation a été ajoutée avec succès !";
                        $_SESSION['alert_type'] = "success";
                    } else {
                        $_SESSION['errmsg'] = "Une erreur est survenue lors de la mise à jour de la consultation !";
                        $_SESSION['alert_type'] = "error";
                    }

                    $stmt2->close();
                } else {
                    $_SESSION['errmsg'] = "Une erreur est survenue lors de l'ajout des informations médicales !";
                    $_SESSION['alert_type'] = "error";
                }

                $stmt1->close();
            } else {
                $_SESSION['errmsg'] = "Une erreur est survenue lors de l'ajout de la consultation !";
                $_SESSION['alert_type'] = "error";
            }

            $stmt->close();
        }
    } else {
        $_SESSION['errmsg'] = "Une erreur est survenue lors de la recherche du patient !";
        $_SESSION['alert_type'] = "error";
    }

    $conn->close();
    header("Location: ajouterCNS.php");
    exit();
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
    <style>
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }
        .success {
            background-color: #4CAF50;
        }
        .error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="top">
            <h2>Ajouter Consultation</h2>
            <a href="infosPerso.php">
                <img src="../icons/medcinIcon.png" alt="Médecin Profile Picture">
            </a>
        </div>

        <div class="content">
            <div class="add-user-form">
                <?php if (isset($_SESSION['errmsg'])): ?>
                    <div class="alert <?php echo $_SESSION['alert_type']; ?>">
                        <?php echo $_SESSION['errmsg']; ?>
                    </div>
                    <?php
                    unset($_SESSION['errmsg']);
                    unset($_SESSION['alert_type']);
                    ?>
                <?php endif; ?>

                <h2>Informations de Consultation</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="CNIpt">CNI Patient:</label>
                        <input type="text" id="CNIpt" name="CNIpt" required>
                    </div>
                    <div class="form-group">
                        <label for="allergies">Allergies:</label>
                        <textarea name="allergies" id="allergies" required rows="4" cols="25"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="observations">Observations:</label>
                        <textarea name="observations" id="observations" required rows="4" cols="25"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="diagnostics">Diagnostics:</label>
                        <textarea name="diagnostics" id="diagnostics" required rows="4" cols="25"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="prescriptions">Prescriptions:</label>
                        <textarea name="prescriptions" id="prescriptions" required rows="4" cols="25"></textarea>
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
                        <label for="frc">Fréquence Cardiaque:</label>
                        <input type="number" id="frc" name="frc" required>
                    </div>
                    <div class="form-group">
                        <label for="note">Note:</label>
                        <textarea name="note" id="note" required rows="4" cols="25"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="datec">Date de Consultation:</label>
                        <input type="date" id="datec" name="datec" required>
                    </div>
                    <button type="submit" name="add">Ajouter la Consultation</button>
                </form>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
