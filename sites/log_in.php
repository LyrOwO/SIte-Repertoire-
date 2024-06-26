<?php
    if (!empty($_POST)){
    // Connexion à la base de données
        include ('includes/db.php');
        $conn = connect();

        // Récupérer les données du formulaire
        $login = $_POST['login'];
        $password = $_POST['password'];

        // Requête SQL paramétrée pour vérifier l'existence de l'utilisateur
        $sql = "SELECT identifiant, mdp FROM connexion WHERE identifiant=:login";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['mdp'])){
            // Utilisateur authentifié, démarrer une session et rediriger
            session_start();
            $_SESSION['login'] = $login;
            header("location: crud.php");
        } else{
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }

        $conn = null; // Fermez la connexion à la base de données
    }
?>
<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="assets/formulaire_stylax.css">
    
    </head>
    <body>
        <form method="post" action="log_in.php">
            Login :<br>
            <input type="text" name="login"><br><br>

            Password :<br>
            <input type="password" name="password"><br><br>

            Se connecter :<br>
            <input type="submit" value="Envoyer"><br><br>
            <a href="register.php">Se créer un compte</a><br><br>
            <a href="index.php">Retour au site</a><br><br>
        </form>
    </body>
</html>