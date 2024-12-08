<?php
include '../includs/db.php'; // Assurez-vous que le chemin est correct

// Vérifiez si un ID d'utilisateur a été fourni
if (!isset($_GET['id'])) {
    die("ID d'utilisateur manquant.");
}

$user_id = $_GET['id'];

// Suppression de l'utilisateur
$stmt = $conn->prepare("DELETE FROM utilisateur WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "Utilisateur supprimé avec succès.";
} else {
    echo "Erreur : " . $stmt->error;
}

// Fermeture de la connexion
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Utilisateur</title>
    <link rel="stylesheet" href="../assets/css/styleAdmin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="page">
        <div class="top">
            <h2>Supprimer Utilisateur</h2>
            <a href="index.php">
                <img src="../icons/adminIcon.png" alt="Admin Profile Picture">
            </a>
        </div>
        <div class="content">
            <p><a href="rechercherUtilisateur.php">Retour à la recherche d'utilisateur</a></p>
        </div>
    </div>
</body>
</html>
