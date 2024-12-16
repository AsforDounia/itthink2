<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT id_utilisateur, mot_de_passe, user_role, email FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        session_start();
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['email'] = $email;
        $_SESSION['user_role'] = $user['user_role'];
        if ($user['user_role'] === 'admin') {
            $queryUsers = "SELECT * FROM utilisateurs ";
            $stmt = $pdo->prepare($queryUsers);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['users'] = $users;

            $queryProjets = "SELECT * FROM Projets ";
            $stmt = $pdo->prepare($queryProjets);
            $stmt->execute();
            $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['projets'] = $projets;

            $queryFreeLances = "SELECT * FROM freelances ";
            $stmt = $pdo->prepare($queryFreeLances);
            $stmt->execute();
            $FreeLances = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['FreeLances'] = $FreeLances;

            $queryOffres = "SELECT * FROM offres ";
            $stmt = $pdo->prepare($queryOffres);
            $stmt->execute();
            $Offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['Offres'] = $Offres;


            header('Location: admin.php');
        } else {
            header('Location: user.php');
        }
        exit;
        exit;
    } else {
        header('Location: index.php?message=identifiants_incorrects');
        exit;
    }
}
?>

