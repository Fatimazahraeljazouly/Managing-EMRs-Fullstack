<?php include ('../includs/db.php'); ?>

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
            <h2>Liste des Utilisateurs</h2>
            <a href="infoPerso.php">
                <img src="../icons/adminIcon.png" alt="Admin Profile Picture">
            </a>    
        </div>

        <div class="content">
            <div class="dme-table">
            <table >
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>CIN</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Rôle</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   $roole="admin";
                    // Requête SQL pour récupérer les utilisateurs
                    $sql = "SELECT idUtilisateur, cin, nom, prenom, email, role FROM utilisateur where role!= ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s",  $roole);
                    $stmt->execute();
                    $result = $stmt->get_result();

                 
                    
                        $var=1;
                    if ($result->num_rows > 0) {
                        // Afficher les données pour chaque ligne
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td style='background-color: #666; color:white;'>" . htmlspecialchars($var) . "</td>
                                    <td>" . htmlspecialchars($row["idUtilisateur"]) . "</td>
                                    <td>" . htmlspecialchars($row["cin"]) . "</td>
                                    <td>" . htmlspecialchars($row["nom"]) . "</td>
                                    <td>" . htmlspecialchars($row["prenom"]) . "</td>
                                    <td>" . htmlspecialchars($row["role"]) . "</td>
                                    <td>
                                        <a href='editUser.php?idUtilisateur=" . htmlspecialchars($row["idUtilisateur"]) . "&cin=" . htmlspecialchars($row["cin"]) . "&nom=" . htmlspecialchars($row["nom"]) . "&prenom=" . htmlspecialchars($row["prenom"]) . "'>Modifier</a> 
                                        <a href='deleteUser.php? idUtilisateur=" . htmlspecialchars($row["idUtilisateur"]). "&cin=" . htmlspecialchars($row["cin"]) .  "&nom=" . htmlspecialchars($row["nom"]) . "&prenom=" . htmlspecialchars($row["prenom"]) ."'>Supprimer</a>
                                    </td>
                                  </tr>";
                                  $var++;
                        }
                    } else {
                        echo "<tr><td colspan='6'>Aucun utilisateur trouvé</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
        </table>
            </div>
       
        </div>

        <?php include 'footer.php'; ?>
    </div>

</body>
</html>
