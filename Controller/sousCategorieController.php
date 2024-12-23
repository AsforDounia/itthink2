<?php

session_start();
require_once '../config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['Ajouter_Sous_Categorie'])){
        
        echo "Ajouter_Sous_Categorie";
        $select_category = (int) $_POST['select_category'];
        $query = "INSERT INTO souscategories (nom_sous_categorie, id_categorie) VALUES (:nom_sous_categorie , :id_categorie)";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':nom_sous_categorie', $_POST['nom_sous_categorie'] );
        $stmt->bindParam(':id_categorie',$select_category);
        $stmt->execute();
        
        $querySous_Categories = "SELECT * FROM souscategories INNER JOIN categories on souscategories.id_categorie = categories.id_categorie";
        $stmtp = $pdo->prepare($querySous_Categories);
        $stmtp->execute();
        $Sous_Categories = $stmtp->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['Sous_Categories'] = $Sous_Categories;
        
        header('Location: ../admin.php?page=Sous_Categories');
    }
    
    if(isset($_POST['sous_categorie_id'])){
        $sous_categorie_id = $_POST['sous_categorie_id'];


        if(isset($_POST['modifierSousCategoies'])){
            echo "$sous_categorie_id";
            $stmt = $pdo->prepare('SELECT * FROM souscategories WHERE id_sous_categorie = :id');
            if ($stmt->execute(['id' => $sous_categorie_id])) {
                $sous_category_data = $stmt->fetch();
                if ($sous_category_data) {
                    $sous_category_param = http_build_query(['sous_category_data' => json_encode($sous_category_data)]);
                    header("Location: ../admin.php?$sous_category_param");
                } else {
                    echo "Aucun utilisateur trouvé avec cet ID.";
                }
            } else {
                echo "Erreur lors de la récupération des données.";
            }
        }
        if(isset($_POST['supprimerSousCategoies'])){
            $stmDeleteProjet = $pdo->prepare("DELETE FROM souscategories WHERE id_sous_categorie = :id");
            $stmDeleteProjet->execute(['id' => $sous_categorie_id]);

            $querySousCategories = "SELECT * FROM souscategories INNER JOIN categories ON souscategories.id_categorie = categories.id_categorie";
            $stmt = $pdo->prepare($querySousCategories);
            $stmt->execute();

            $_SESSION['Sous_Categories'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header("Location: ../admin.php?page=Sous_Categories");
            exit;


        }
        if(isset($_POST['confirmModifierSousCategory'])){
            if (isset($_POST['sous_categorie_id'], $_POST['name_souscategory_modify'], $_POST['select_category_sousCat'])) {

                $id_categorie = $_POST['select_category_sousCat'];
                $nom_sous_categorie = $_POST['name_souscategory_modify'];
                $sous_categorie_id = $_POST['sous_categorie_id'];

                $stmt = $pdo->prepare('UPDATE souscategories SET nom_sous_categorie = :nom_sous_categorie, id_categorie = :id_categorie WHERE id_sous_categorie = :id_sous_categorie');

                if ($stmt->execute(['nom_sous_categorie' => $nom_sous_categorie,'id_categorie' => $id_categorie,'id_sous_categorie' => $sous_categorie_id])) {
                    $querySousCategories = "SELECT * FROM souscategories INNER JOIN categories ON souscategories.id_categorie = categories.id_categorie";
                    $stmt = $pdo->prepare($querySousCategories);
                    $stmt->execute();

                    $_SESSION['Sous_Categories'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    header("Location: ../admin.php?page=Sous_Categories");
                    exit;
                } else {
                    echo "Erreur : la mise à jour de la sous-catégorie a échoué.";
                }
            } else {
                echo "Erreur : données manquantes pour effectuer la modification.";
            }

        }

    }
    if(isset($_POST['annuler'])){
        header('Location: ../admin.php?page=Sous_Categories');
    }
}
?>


