<?php
include '../includs/db.php'; 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];
    $stmt1 = $conn->prepare("DELETE FROM secretaire WHERE idUtilisateur = ?");
    $stmt1->bind_param("i", $user_id);
    $stmt1->execute();

    $stmt2 = $conn->prepare("DELETE FROM medecin WHERE idUtilisateur = ?");
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();

    $stmt3 = $conn->prepare("DELETE FROM secretaire WHERE idUtilisateur = ?");
    $stmt3->bind_param("i", $user_id);
    $stmt3->execute();

    // Suppression de l'utilisateur
    $stmt = $conn->prepare("DELETE FROM utilisateur WHERE idUtilisateur = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $message = "Utilisateur supprimé avec succès.";
    } else {
        $message = "Erreur : " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Utilisateurs</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'dashboard.php'; ?>

    <div class="page">
        <div class="top">
            <h2>Supprimer Utilisateurs</h2>
            <a href="infoPerso.php">
                <img src="../icons/adminIcon.png" alt="Admin Profile Picture">
            </a>    
        </div>

        <div class="content">
            <div class="search-user-form">
                <h2>Rechercher un utilisateur</h2>
                <form action="" method="get">
                    <div class="form-group">
                        <label for="nome">Nom:</label>
                        <input type="text" id="nome" name="nome">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom">
                    </div>
                    <div class="form-group">
                        <label for="cin">CIN:</label>
                        <input type="text" id="cin" name="cin">
                    </div>
                    <button type="submit">Rechercher</button>
                </form>
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['nome']) || isset($_GET['prenom']) || isset($_GET['cin']))) {
                $nome = $_GET['nome'] ?? '';
                $prenom = $_GET['prenom'] ?? '';
                $cin = $_GET['cin'] ?? '';

                // Préparer les valeurs de recherche
                $nome_like = "%$nome%";
                $prenom_like = "%$prenom%";
                $cin_like = "%$cin%";

                // Requête SQL pour rechercher des utilisateurs correspondant aux critères
                $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE nom LIKE ? AND prenom LIKE ? AND cin LIKE ?");
                $stmt->bind_param("sss", $nome_like, $prenom_like, $cin_like);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<h3>Résultats de la recherche :</h3>";
                    echo "<table><tr><th>Nom</th><th>Prénom</th><th>CIN</th><th>Actions</th></tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>" . $row["nom"] . "</td>
                        <td>" . $row["prenom"] . "</td>
                        <td>" . $row["cin"] . "</td>
                        <td>
                            <form action='' method='post' style='display:inline;'>
                            <input type='hidden' name='user_id' value='" . $row['idUtilisateur'] . "'>
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
