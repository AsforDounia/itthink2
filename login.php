<?php
require_once 'config.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT id_utilisateur, mot_de_passe, user_role, email FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);













    if ($user && password_verify($password, $user['mot_de_passe'])) {

        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['email'] = $email;
        $_SESSION['user_role'] = $user['user_role'];



        $queryCategories = "SELECT * FROM Categories ";
        $stmt = $pdo->prepare($queryCategories);
        $stmt->execute();
        $Categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['Categories'] = $Categories;
    
    
        $querySous_Categories = "SELECT * FROM souscategories INNER JOIN categories on souscategories.id_categorie = categories.id_categorie";
        $stmt = $pdo->prepare($querySous_Categories);
        $stmt->execute();
        $Sous_Categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['Sous_Categories'] = $Sous_Categories;
    
    
    
        $queryFreeLances = "SELECT * FROM freelances INNER JOIN utilisateurs ON freelances.id_utilisateur = utilisateurs.id_utilisateur ";
        $stmt = $pdo->prepare($queryFreeLances);
        $stmt->execute();
        $FreeLances = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['FreeLances'] = $FreeLances;


        $queryProjets = "SELECT * FROM Projets INNER JOIN utilisateurs on Projets.id_utilisateur = utilisateurs.id_utilisateur";
        $stmt = $pdo->prepare($queryProjets);
        $stmt->execute();
        $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['projets'] = $projets;

        if ($user['user_role'] == 'admin') {
            $queryUsers = "SELECT * FROM utilisateurs ";
            $stmt = $pdo->prepare($queryUsers);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['users'] = $users;





            $queryOffres = "SELECT * FROM Offres ";
            $stmt = $pdo->prepare($queryOffres);
            $stmt->execute();
            $Offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['Offres'] = $Offres;




            $querytemoignages = "SELECT * FROM temoignages INNER JOIN utilisateurs ON temoignages.id_utilisateur = utilisateurs.id_utilisateur ";
            $stmt = $pdo->prepare($querytemoignages);
            $stmt->execute();
            $temoignages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['temoignages'] = $temoignages;


            header('Location: admin.php');
        } else {
            $stmt = $pdo->prepare("SELECT * FROM Projets WHERE id_utilisateur = :id_utilisateur");
            $stmt->execute(['id_utilisateur' => $_SESSION['user_id']]);

            $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['userProjets'] = $projets;
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

