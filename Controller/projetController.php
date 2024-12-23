<?php

session_start();
require_once '../config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['Ajouter_Projet'])){
        
        $query = "INSERT INTO Projets (titre_projet, description, id_categorie, id_sous_categorie, id_utilisateur) VALUES (:title, :description, :category, :subcategory, :user)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->bindParam(':category', $_POST['category']);
        $stmt->bindParam(':subcategory', $_POST['subcategory']);
        $stmt->bindParam(':user', $_SESSION['user_id']);
        $stmt->execute();
        
        $queryProjets = "SELECT * FROM Projets ";
        $stmtp = $pdo->prepare($queryProjets);
        $stmtp->execute();
        $projets = $stmtp->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['projets'] = $projets;
        if($_SESSION['user_role'] == "admin"){
            header('Location: ../admin.php?page=projets');
        }
        else{

            $stmt = $pdo->prepare("SELECT * FROM Projets WHERE id_utilisateur = :id_utilisateur");
            $stmt->execute(['id_utilisateur' => $_SESSION['user_id']]);

            $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['userProjets'] = $projets;
            header('Location: ../user.php?page=projets');

        }
    }
    if(isset($_POST['id_projet'])){
        $id_projet = $_POST['id_projet'];
        if(isset($_POST['modifierProjet'])){
            $stmt = $pdo->prepare('SELECT * FROM projets WHERE id_projet = :id');
            if ($stmt->execute(['id' => $id_projet])) {
                $project_data = $stmt->fetch();
                if ($project_data) {
                    $project_param = http_build_query(['project_data' => json_encode($project_data)]);
                    if($_SESSION['user_role'] == "admin"){
                        header("Location: ../admin.php?$project_param");
                    }
                    else{
                        $stmt = $pdo->prepare("SELECT * FROM Projets WHERE id_utilisateur = :id_utilisateur");
                        $stmt->execute(['id_utilisateur' => $_SESSION['user_id']]);
            
                        $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $_SESSION['userProjets'] = $projets;
                        header("Location: ../user.php?$project_param");

                    }
                } else {
                    echo "Aucun utilisateur trouvé avec cet ID.";
                }
            } else {
                echo "Erreur lors de la récupération des données.";
            }
        }
        if(isset($_POST['supprimerProjet'])){
            $stmDeleteProjet = $pdo->prepare("DELETE FROM Projets WHERE id_projet = :id");
            $stmDeleteProjet->execute(['id' => $id_projet]);

            $queryProjets = "SELECT * FROM Projets ";
            $stmt = $pdo->prepare($queryProjets);
            $stmt->execute();
            $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['projets'] = $projets;
                       
            if($_SESSION['user_role'] == "admin"){
                header('Location: ../admin.php?page=projets');
            }
            else{
                $stmt = $pdo->prepare("SELECT * FROM Projets WHERE id_utilisateur = :id_utilisateur");
                $stmt->execute(['id_utilisateur' => $_SESSION['user_id']]);

                $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION['userProjets'] = $projets;
                header('Location: ../user.php?page=projets');
            }

        }
        if(isset($_POST['modifierProject'])){
            // Vérifier que les données sont présentes
            if (isset($_POST['id_projet'], $_POST['name_projet_modify'], $_POST['description_projet_modify'], $_POST['category_projet_modify'], $_POST['subcategory_projet_modify'])) {
                // Récupération et nettoyage des données
                $id_projet = (int) $_POST['id_projet'];
                $titre_projet = $_POST['name_projet_modify'];
                $description = $_POST['description_projet_modify'];
                $id_categorie = (int) $_POST['category_projet_modify'];
                $id_sous_categorie = (int) $_POST['subcategory_projet_modify'];
                $satut = $_POST['status_selected'];

                $stmt = $pdo->prepare('UPDATE projets SET titre_projet = :titre_projet, description = :description, id_categorie = :id_categorie, id_sous_categorie = :id_sous_categorie, id_utilisateur = :id_utilisateur, date_creation = CURRENT_TIMESTAMP, statut = :status WHERE id_projet = :id_projet');

                if ($stmt->execute(['titre_projet' => $titre_projet,'description' => $description,'id_categorie' => $id_categorie,'id_sous_categorie' => $id_sous_categorie,'id_utilisateur' => (int) $_SESSION['user_id'],'status' => $satut ,'id_projet' => $id_projet])){
                    $queryProjets = "SELECT * FROM Projets ";
                    $stmt = $pdo->prepare($queryProjets);
                    $stmt->execute();
                    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $_SESSION['projets'] = $projets;

                    if($_SESSION['user_role'] == "admin"){
                        header('Location: ../admin.php?page=projets');
                    }
                    else{
                        $stmt = $pdo->prepare("SELECT * FROM Projets WHERE id_utilisateur = :id_utilisateur");
                        $stmt->execute(['id_utilisateur' => $_SESSION['user_id']]);

                        $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $_SESSION['userProjets'] = $projets;
                        header('Location: ../user.php?page=projets');
                    }
                    
                    exit;
                } else {
                    echo "Erreur lors de la modification du projet.";
                }
            } else {
                echo "Des données manquent pour effectuer la modification.";
            }
        }

    }
    if(isset($_POST['annuler'])){
        if($_SESSION['user_role'] == "admin"){
            header('Location: ../admin.php?page=projets');
        }
        else{
            $stmt = $pdo->prepare("SELECT * FROM Projets WHERE id_utilisateur = :id_utilisateur");
            $stmt->execute(['id_utilisateur' => $_SESSION['user_id']]);

            $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['userProjets'] = $projets;
            header('Location: ../user.php?page=projets');
        }
    }
}
?>


