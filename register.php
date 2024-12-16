<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userName = $_POST['user_name'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Vérifier s'il y a des utilisateurs existants
    $checkQuery = "SELECT COUNT(*) FROM utilisateurs";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute();
    $userCount = $checkStmt->fetchColumn();

    $userRole = $userCount === 0 ? 'admin' : 'user';

    $query = "INSERT INTO utilisateurs (email, mot_de_passe, nom_utilisateur, user_role) VALUES (:email, :password, :nom_utilisateur , :role)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(':nom_utilisateur', $userName, PDO::PARAM_STR);
    $stmt->bindParam(':role', $userRole, PDO::PARAM_STR);

    try {
        $stmt->execute();
        header('Location: index.php?message=inscription_reussie');
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header('Location: inscription.php?error=email_deja_enregistre');
            exit;
        } else {
            header('Location: inscription.php?error=une_erreur_est_survenue');
            exit;
        }
    }
}
?>