<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système GDME</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styleLogin.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card login-card p-4">
            <div class="card-body">
                <img   src="../icons/infermierIcon.png" alt="" style="margin-left: 40%;">
                <h2 class="text-center mb-4">Connexion Infirmier</h2>
                <hr>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="Utilisateur">Nom D'Utilisateur</label>
                        <input type="text" name="Utilisateur" id="Utilisateur" class="form-control" placeholder="Utilisateur" required>
                    </div>
                    <div class="form-group">
                        <label for="MotDePass">Mot de Passe</label>
                        <input type="password" name="MotDePass" id="MotDePass" class="form-control" placeholder="Mot de Passe" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="../index.php" class="text-muted">Retour</a>
                        <a href="#" class="text-muted">Mot de Passe Oublié?</a>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-block mt-4">Connexion</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
