<?php
include ('../includs/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'dashboard.php'; ?>

    <div class="page">
        <div class="top">
            <h2>Liste des Patients</h2>
            <a href="infosPerso.php">
                <img  src="../icons/secritaireIcon.png" alt="Admin Profile Picture">
            </a>
        </div>

        <div class="content">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CIN</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de Naissance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['idSec'])) {
                        $idSec = $_SESSION['idSec'];
                        //  Récupérer les patients
                        $sql = "SELECT a.idUtilisateur,a.idPt, u.nom, u.prenom, u.cin, a.datenaissance 
                                FROM utilisateur u 
                                JOIN patient a ON u.idUtilisateur = a.idUtilisateur 
                                WHERE a.idSecretaire = ?";
                        $stmt = $conn->prepare($sql);

                        if ($stmt) {
                            $stmt->bind_param("i", $idSec);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                // Afficher les données pour chaque ligne
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row["idPt"]) . "</td>
                                            <td>" . htmlspecialchars($row["cin"]) . "</td>
                                            <td>" . htmlspecialchars($row["nom"]) . "</td>
                                            <td>" . htmlspecialchars($row["prenom"]) . "</td>
                                            <td>" . htmlspecialchars($row["datenaissance"]) . "</td>
                                            <td>
                                                <a href='editUser.php?idUtilisateur=" . htmlspecialchars($row["idUtilisateur"]) . "&cin=" . htmlspecialchars($row["cin"]) . "&nom=" . htmlspecialchars($row["nom"]) . "&prenom=" . htmlspecialchars($row["prenom"]) . "'>Modifier</a> 
                                                <a href='deleteUser.php?idUtilisateur=" . htmlspecialchars($row["idUtilisateur"]) . "&cin=" . htmlspecialchars($row["cin"]) . "&nom=" . htmlspecialchars($row["nom"]) . "&prenom=" . htmlspecialchars($row["prenom"]) . "'>Supprimer</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Aucun utilisateur trouvé</td></tr>";
                            }

                            $stmt->close();
                        } else {
                            // Affiche l'erreur de préparation de la requête SQL
                            echo "<tr><td colspan='6'>Erreur de préparation de la requête : " . $conn->error . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Identifiant de la secrétaire non trouvé dans la session.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <?php include 'footer.php'; ?>
    </div>

</body>
</html>
