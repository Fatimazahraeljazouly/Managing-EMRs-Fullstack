<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher Utilisateur</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'dashboard.php'; ?>

    <div class="page">
        <div class="top">
            <h2>Rechercher Utilisateur</h2>
            <a href="infoPerso.php">
                <img src="../icons/adminIcon.png" alt="Admin Profile Picture">
            </a>    
        </div>

        <div class="content">
            <div class="search-user">
                <h2>Rechercher Utilisateur</h2>
                <form method="GET" action="searchUser.php">
                    <div class="form-group">
                        <label for="search">Critères de Recherche:</label>
                        <input type="text" id="search" name="search" placeholder="Nom, Prénom, Email, etc.">
                    </div>
                    <button type="submit">Rechercher</button>
                </form>
            </div>

            <?php
            if (isset($_GET['search'])) {
                // Connexion à la base de données
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "gestion_dme";

                // Créer la connexion
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Vérifier la connexion
                if ($conn->connect_error) {
                    die("Connexion échouée: " . $conn->connect_error);
                }

                $search = $_GET['search'];
                $sql = "SELECT id, first_name, last_name, email, role FROM users 
                        WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' OR role LIKE '%$search%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>
                            <tr>
                                <th>ID</th>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Action</th>
                            </tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['first_name']}</td>
                                <td>{$row['last_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['role']}</td>
                                <td><a href='editUser.php?id={$row['id']}'>Modifier</a></td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "Aucun utilisateur trouvé.";
                }

                $conn->close();
            }
            ?>
        </div>

        <?php include 'footer.php' ?>

    </div>
</body>
</html>
