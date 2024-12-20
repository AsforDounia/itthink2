<?php
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['id_utilisateur'])){
        $id = $_POST['id_utilisateur'];
        if (isset($_POST['supprimerUser'])) {
            $stmt = $pdo->prepare('DELETE FROM utilisateurs WHERE id_utilisateur = :id');
            if ($stmt->execute(['id' => $id])) {
                $queryUsers = "SELECT * FROM utilisateurs ";
                $stmt = $pdo->prepare($queryUsers);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION['users'] = $users;
                header("Location: ../admin.php");
            } else {
                echo "Erreur lors de la suppression de l'utilisateur.";
            }
        } elseif (isset($_POST['modifierUser'])) {
            $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur = :id');
            if ($stmt->execute(['id' => $id])) {
                $donnees = $stmt->fetch();
                if ($donnees) {
                    $queryParams = http_build_query(['donnees' => json_encode($donnees)]);
                    header("Location: ../admin.php?$queryParams");
                } else {
                    echo "Aucun utilisateur trouvé avec cet ID.";
                }
            } else {
                echo "Erreur lors de la récupération des données.";
            }
        }
    }


    if(isset($_POST['modifierRole'])){
        $user_id = $_POST['id_user_modify'];
        $new_role = $_POST['new_user_role'];
        $stmt = $pdo->prepare('UPDATE utilisateurs SET user_role = :new_role WHERE id_utilisateur = :user_id');
        if ($stmt->execute(['new_role' => $new_role, 'user_id' => $user_id])) {
            $queryUsers = "SELECT * FROM utilisateurs ";
            $stmt = $pdo->prepare($queryUsers);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['users'] = $users;
            header("Location: ../admin.php");
            exit;
            } else {
                echo "Erreur lors de la modification du role.";
            }
    }
    if(isset($_POST['adminAddUser'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $userName = $_POST['user_name'];
        $user_role = $_POST['user_role'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if(!empty($email) && !empty($password) && !empty($userName) && !empty($user_role)){

        $query = "INSERT INTO utilisateurs (email, mot_de_passe, nom_utilisateur, user_role) VALUES (:email, :password, :nom_utilisateur , :role)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':nom_utilisateur', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':role', $user_role, PDO::PARAM_STR);
        }
        else{
            header('Location: ../admin.php?error=missing_fields');
            exit;
        }
        try {
            $stmt->execute();
            $queryUsers = "SELECT * FROM utilisateurs ";
            $stmt = $pdo->prepare($queryUsers);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['users'] = $users;
            header('Location: ../admin.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                header('Location: ../admin.php?error=email_deja_enregistre');
                exit;
            } else {
                header('Location: ../admin.php?error=une_erreur_est_survenue');
                exit;
            }
        }

    }

    if(isset($_POST['annuler'])){
        header('Location: ../admin.php');
    }
}




?>
