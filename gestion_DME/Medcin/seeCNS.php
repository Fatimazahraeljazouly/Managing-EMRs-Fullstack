<?php
include 'dashboard.php';
include '../includs/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username']) || !isset($_SESSION['idMd'])) {
    die("Erreur : médecin non connecté.");
} else {
    $username = $_SESSION['username'];
    $idMd = $_SESSION['idMd'];
}

// Fonction pour rechercher un patient et ses consultations
function searchPatientConsultations($conn, $idMd, $nom, $prenom, $cin) {
    $nom_like = "%$nom%";
    $prenom_like = "%$prenom%";
    $cin_like = "%$cin%";
    
    $stmt = $conn->prepare("SELECT u.nom, u.prenom, u.cin, c.date, c.notes, i.taille, i.poids, i.tensionArterielle, i.frequenceCardiaque
                            FROM utilisateur u
                            JOIN patient p ON p.idUtilisateur = u.idUtilisateur
                            JOIN dossiermedical d ON d.idPt = p.idPt
                            JOIN informationsmedicale i ON i.idPt = p.idPt
                            JOIN consultation c ON c.id = i.idConsultation
                            WHERE d.idMd = ? and c.idMd=?
                            AND u.nom LIKE ?
                            AND u.prenom LIKE ?
                            AND u.cin LIKE ?
                            ORDER BY c.date DESC;");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("iisss",$idMd, $idMd, $nom_like, $prenom_like, $cin_like);
    $stmt->execute();
    $result = $stmt->get_result();
    $consultations = $result->fetch_all(MYSQLI_ASSOC);
   

    $stmt->close();

    return $consultations;
}

$consultations = [];
$search_message = "";

// Recherche patient et consultations si le formulaire de recherche est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $cin = $_POST['cin'] ?? '';
    $consultations = searchPatientConsultations($conn, $idMd, $nom, $prenom, $cin);
    if (!$consultations) {
        $search_message = "Aucun patient trouvé avec ces critères.";
    }
}
?>

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
            <h2>Consultations Par Patient</h2>
            <a href="infosPerso.php">
                <img src="../icons//medcinIcon.png" alt="Admin Profile Picture">
            </a>
        </div>

        <div class="content">
            <!-- Formulaire de recherche -->
            <div class="search-user-form">
                <h2>Rechercher un  Patient</h2>
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
                    <button type="submit" name="search">Rechercher</button>
                </form>
                <?php if ($search_message): ?>
                    <p><?php echo htmlspecialchars($search_message); ?></p>
                <?php endif; ?>
            </div>

            <!-- Affichage des consultations -->

            <?php if (!empty($consultations)): ?>
<?php $num=0; ?>
                <div class="dme-table">
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
                                <td data-label='Date' ><?php echo htmlspecialchars($consultation['date']); ?></td>
                                <td data-label='Notes' ><?php echo htmlspecialchars($consultation['notes']); ?></td>
                                <td data-label='Taille(m)' > <?php echo htmlspecialchars($consultation['taille']); ?></td>
                                <td data-label='Poids(Kg)'><?php echo htmlspecialchars($consultation['poids']); ?></td>
                                <td data-label='Tension Arterielle'><?php echo htmlspecialchars($consultation['tensionArterielle']); ?></td>
                                <td data-label='Frequence Cardiaque' ><?php echo htmlspecialchars($consultation['frequenceCardiaque']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
                
            <?php endif; ?>
        </div>
        <?php include "footer.php" ?>
    </div>
</body>
</html>
