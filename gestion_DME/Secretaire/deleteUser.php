<?php
include '../includs/db.php'; 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];
    if (isset($_SESSION['idSec'])) {
        $idSec = $_SESSION['idSec'];

        // Suppression des patients ajoutés par le secrétaire connecté
        $stmt1 = $conn->prepare("DELETE FROM patient WHERE idUtilisateur = ? AND idSecretaire = ?");
        $stmt1->bind_param("ii", $user_id, $idSec);
        $stmt1->execute();

        // Suppression de l'utilisateur si et seulement si l'utilisateur est un patient
        $stmt = $conn->prepare("DELETE FROM utilisateur WHERE idUtilisateur = ? AND EXISTS (SELECT 1 FROM patient WHERE idUtilisateur = ?)");
        $stmt->bind_param("ii", $user_id, $user_id);

        if ($stmt->execute()) {
            $message = "Patient supprimé avec succès.";
        } else {
            $message = "Erreur : " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Utilisateurs</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'dashboard.php'; ?>

    <div class="page">
        <div class="top">
            <h2>Supprimer Patient</h2>
            <a href="infosPerso.php">
                <img  src="../icons/secritaireIcon.png" alt="Admin Profile Picture">
            </a>
        </div>

        <div class="content">
            <div class="search-user-form">
                <h2>Rechercher un Patient</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="cin">CIN:</label>
                        <input type="text" id="cin" name="cin">
                    </div>
                    <div class="form-group">
                        <label for="nome">Nom:</label>
                        <input type="text" id="nome" name="nome">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom">
                    </div>
                    <button type="submit">Rechercher</button>
                </form>
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['nome']) || isset($_POST['prenom']) || isset($_POST['cin']))) {
                $nome = $_POST['nome'] ?? '';
                $prenom = $_POST['prenom'] ?? '';
                $cin = $_POST['cin'] ?? '';
                $nome_like = "%$nome%";
                $prenom_like = "%$prenom%";
                $cin_like = "%$cin%";

                if (isset($_SESSION['idSec'])) {
                    $idSec = $_SESSION['idSec'];

                    // Requête SQL pour rechercher des utilisateurs correspondant aux critères et ajoutés par le secrétaire connecté
                    $stmt = $conn->prepare("SELECT u.idUtilisateur, u.nom, u.cin, u.prenom 
                                            FROM utilisateur u 
                                            JOIN patient p ON u.idUtilisateur = p.idUtilisateur 
                                            WHERE p.idSecretaire = ? 
                                            AND u.nom LIKE ? 
                                            AND u.prenom LIKE ? 
                                            AND u.cin LIKE ?");
                    $stmt->bind_param("isss", $idSec, $nome_like, $prenom_like, $cin_like);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo "<h3>Résultats de la recherche :</h3>";
                        echo "<table><tr><th>Nom</th><th>Prénom</th><th>CIN</th><th>Actions</th></tr>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["nom"]) . "</td>
                                    <td>" . htmlspecialchars($row["prenom"]) . "</td>
                                    <td>" . htmlspecialchars($row["cin"]) . "</td>
                                    <td>
                                        <form action='' method='post' style='display:inline;'>
                                            <input type='hidden' name='user_id' value='" . htmlspecialchars($row['idUtilisateur']) . "'>
                                            <button type='submit' name='delete' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur?\");'>Supprimer</button>
                                        </form>
                                    </td>
                                  </tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "<p>Aucun utilisateur trouvé.</p>";
                    }

                    $stmt->close();
                }
            }

            if (isset($message)) {
                echo "<p>$message</p>";
            }

            $conn->close();
            ?>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
