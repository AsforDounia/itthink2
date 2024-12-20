<?php

session_start();
require_once '../config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['Ajouter_Categorie'])){
        
        $query = "INSERT INTO categories (nom_categorie) VALUES (:nom_categorie)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nom_categorie', $_POST['nom_categorie']);
        $stmt->execute();
        
        $queryCategories = "SELECT * FROM Categories ";
        $stmtp = $pdo->prepare($queryCategories);
        $stmtp->execute();
        $Categories = $stmtp->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['Categories'] = $Categories;
        
        header('Location: ../admin.php?page=Categories');
    }
    if(isset($_POST['id_categorie'])){
        $id_categorie = $_POST['id_categorie'];
        if(isset($_POST['modifierCategory'])){
            $stmt = $pdo->prepare('SELECT * FROM Categories WHERE id_categorie = :id');
            if ($stmt->execute(['id' => $id_categorie])) {
                $category_data = $stmt->fetch();
                if ($category_data) {
                    $category_param = http_build_query(['category_data' => json_encode($category_data)]);
                    header("Location: ../admin.php?$category_param");
                } else {
                    echo "Aucun utilisateur trouvé avec cet ID.";
                }
            } else {
                echo "Erreur lors de la récupération des données.";
            }
        }
        if(isset($_POST['supprimerCategory'])){
            $stmDeleteProjet = $pdo->prepare("DELETE FROM Categories WHERE id_categorie = :id");
            $stmDeleteProjet->execute(['id' => $id_categorie]);

            $queryCategories = "SELECT * FROM Categories ";
            $stmt = $pdo->prepare($queryCategories);
            $stmt->execute();
            $Categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['Categories'] = $Categories;
            header('Location: ../admin.php?page=Categories');

        }
        if(isset($_POST['confirmModifierCategory'])){

            if (isset($_POST['id_categorie'], $_POST['name_category_modify'])) {

                $id_categorie = $_POST['id_categorie'];

                $nom_categorie = $_POST['name_category_modify'];

                $stmt = $pdo->prepare('UPDATE categories SET nom_categorie = :nom_categorie WHERE id_categorie = :id_categorie');

                if ($stmt->execute(['nom_categorie' => $nom_categorie,'id_categorie' => $id_categorie])){
                    
                    $queryCategories = "SELECT * FROM Categories ";
                    $stmt = $pdo->prepare($queryCategories);
                    $stmt->execute();
                    $Categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $_SESSION['Categories'] = $Categories;

                    header("Location: ../admin.php?page=Categories");
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
        header('Location: ../admin.php?page=Categories');
    }
}
?>


