<?php
 session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Learnify Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- <script src="js/script.js"></script> -->
  
</head>
<body class="bg-black h-screen">
<section class="m-5">

  <!-- Container principal -->
  <div class="flex border-2 border-white rounded-xl overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-20 bg-gray-800 flex flex-col items-center space-y-8 py-28 relative">
        <div class="h-10 w-10 rounded-full bg-gray-300 flex flex-col items-center justify-center absolute top-8 cursor-pointer">
        <!-- <i class="fas fa-user"></i> -->
         <img src="img/profile.png" alt="">
        <!-- <i class="fas fa-sign-out-alt"></i> -->
        </div>
      <div class="h-10 w-10 bg-white rounded-md"></div>
      <div class="h-10 w-10 bg-gray-400 rounded-md"></div>
      <div class="h-10 w-10 bg-gray-400 rounded-md"></div>
      <div class="h-10 w-10 bg-gray-400 rounded-md"></div>
      <div class="h-10 w-10 bg-gray-400 rounded-md"></div>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 p-8 bg-gray-100 ">
      <!-- Header -->
      <header class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div>
            <div class="flex justify-end">
                <button class="bg-red-500 p-2 px-4 m-3 rounded-md mr-0 -mt-3">Deconnetion</button>
            </div>
            <div class="flex items-center space-x-4">
                <input type="text" placeholder="Search" class="border rounded-lg py-2 px-4">
                <div class="h-10 w-10 rounded-full bg-gray-300 flex flex-col items-center justify-center">
                    <?php
                if (isset($_SESSION['notification'])) {
                    echo '<i class="fas fa-bell text-red-500 cursor-pointer" onclick="return showSection(\'notification\', \'\')"></i>';
                } else {
                    echo '<i class="fas fa-bell text-gray-400 cursor-pointer" onclick="return showSection(\'notification\', \'\')"></i>';
                }
                ?>

<!-- <i class="fas fa-bell"></i> -->
</div>
</div>
        </div>
      </header>

      <!-- Section des cartes -->
      <section class="grid grid-cols-4 gap-6 mb-8 ">
        <div class="bg-purple-300 py-4 p-4 rounded-lg text-center flex flex-col items-center cursor-pointer relative group">
          <h2 class="text-xl font-semibold mb-4">Nombre total des projets</h2>
          <div class="font-bold text-3xl"><?php echo count($_SESSION['projets']) ; ?></div>
          <button onclick="return gestion('projets')" class="bg-purple-300 p-2 rounded-md absolute w-full h-full top-0 hidden group-hover:block text-black text-xl font-bold">Gestion des Projets</button>

        </div>

      </section>

      <!-- Tableau des utilisateurs -->
  <section  id="users" class="bg-white p-4 rounded-lg cartSection ">
    <div  class="flex justify-between">
      <h2 class="text-xl font-semibold mb-4">Tous les utilisateurs</h2>
      <button onclick="return new_user_form()" class="text-sm mb-4 p-2 font-semibold rounded-lg bg-yellow-400 text-gray-800 hover:underline">Ajouter Utilisateur</button>
    </div>
    <div class="overflow-auto h-60">

    <table class="w-full " >
        <thead class="">
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Nom</th>
                <th class="py-2 text-left">Email</th>
                <th class="py-2 text-left">Rôle</th>
                <th class="py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = $_SESSION['users'];
            if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= htmlspecialchars($user['id_utilisateur']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($user['nom_utilisateur']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($user['email']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($user['user_role']); ?></td>
                        <?php if($user['id_utilisateur'] != $_SESSION['user_id']): ?>
                        <td class="py-2 text-center">
                            <div class="flex justify-center">
                            <form action="Controller/userController.php" method="POST"  class="inline px-2">
                                <input type="hidden" name="id_utilisateur" value="<?= $user['id_utilisateur']; ?>">
                                <button type="submit" name="modifierUser" value="modifier" class=" text-blue-500 hover:underline">Modifier </button>
                            </form>
                            <span> | </span>
                            <form action="Controller/userController.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="inline px-2">
                                <input type="hidden" name="id_utilisateur" value="<?= $user['id_utilisateur']; ?>">
                                <button type="submit" name="supprimerUser" value="supprimer" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                            </div>
                        </td>
                        <?php else: ?>
                        <td class="py-2 text-center">
                            <a href="modifyCompte.php?id=<?= $user['id_utilisateur']; ?>" class="text-blue-500 hover:underline">Modifier</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="py-4 text-center">Aucun utilisateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>

</section>



<section id="projets" class="bg-white p-4 rounded-lg hidden cartSection overflow-auto h-72">
    <div  class="flex justify-between">
      <h2 class="text-xl font-semibold mb-4">Tous les Projets</h2>
      <button onclick="return addprojetForm()" class="text-sm mb-4 p-2 font-semibold rounded-lg bg-yellow-400 text-gray-800   hover:underline">Ajouter Projet</button>
    </div>
    <div class="overflow-auto h-60">
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Titre</th>
                <th class="py-2 text-left">Description</th>
                <th class="py-2 text-left">ID Categorie</th>
                <th class="py-2 text-left">ID Sous Categorie</th>
                <th class="py-2 text-left">ID Utilisateur</th>
                <th class="py-2 text-left">Date De Creation</th>
                <th class="py-2 text-left">Statut</th>
                <th class="py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $projets = $_SESSION['projets'];
            if (!empty($projets)): ?>
                <?php foreach ($projets as $projet): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= htmlspecialchars($projet['id_projet']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($projet['titre_projet']); ?></td>
                        
                        <?php 
                            $desc = $projet['description'] ;
                            $shortDesc = mb_strimwidth($projet['description'], 0, 10, '...');
                        ?>
                        <td class="py-2 hover:text-blue-500 hover:underline cursor-pointer"><div onclick="return showSection('description','<?= $desc ?>')"><?= htmlspecialchars($shortDesc); ?></div></td>
                        <?php $cat = $projet['id_categorie'] ;?>
                        <td class="py-2"><div onclick="return showSection('categorie','<?= $cat ?>')"><?= htmlspecialchars($projet['id_categorie']); ?></div></td>
                        <td class="py-2"><?= htmlspecialchars($projet['id_sous_categorie']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($projet['id_utilisateur']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($projet['date_creation']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($projet['statut']); ?></td>

                        <td class="py-2 text-center">
                        <?php if($projet['id_utilisateur'] == $_SESSION['user_id']): ?>
                            <div class="flex justify-center">
                            <form action="Controller/projetController.php" method="POST"  class="inline px-2">
                                <input type="hidden" name="id_projet" value="<?= $projet['id_projet']; ?>">
                                <button type="submit" name="modifierProjet" value="modifier" class=" text-blue-500 hover:underline">Modifier </button>
                            </form>
                            <span> | </span>
                            <?php endif; ?>
                            <form action="Controller/projetController.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');" class="inline px-2">
                                <input type="hidden" name="id_projet" value="<?= $projet['id_projet']; ?>">
                                <button type="submit" name="supprimerProjet" value="supprimer" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                            </div>

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="py-4 text-center">Aucun Projet trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</section>












<section  id="freelances" class="bg-white p-4 rounded-lg  hidden cartSection overflow-auto h-72">
    <div  class="flex justify-between">
      <h2 class="text-xl font-semibold mb-4">Tous les FreeLances</h2>
      <button onclick="return addFreeLance()" class="text-sm mb-4 p-2 font-semibold rounded-lg bg-yellow-400 text-gray-800   hover:underline">Ajouter FreeLance</button>
    </div>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Nom</th>
                <th class="py-2 text-left">Email</th>
                <th class="py-2 text-left">Role</th>
                <th class="py-2 text-left">Competences</th>


                <th class="py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $FreeLances = $_SESSION['FreeLances'];
            if (!empty($FreeLances)): ?>
                <?php foreach ($FreeLances as $FreeLance): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= htmlspecialchars($FreeLance['id_freelance']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($FreeLance['nom_utilisateur']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($FreeLance['email']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($FreeLance['user_role']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($FreeLance['competences']); ?></td>
                        <td class="py-2 text-center">
                        <div class="flex justify-center">
                            <form action="Controller/freeLanceController.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce freelance ?');" class="inline px-2">
                                <input type="hidden" name="id_freelance" value="<?= $FreeLance['id_freelance']; ?>">
                                <button type="submit" name="supprimerFreelance" value="supprimer" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                            </div>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="py-4 text-center">Aucun FreeLance trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<section  id="Offres" class="bg-white p-4 rounded-lg  hidden cartSection overflow-auto h-72">
    <div  class="flex justify-between">
        <h2 class="text-lg font-semibold mb-4">Tous les Offres</h2>
      <button class="text-sm mb-4 p-2 font-semibold rounded-lg bg-yellow-400 text-gray-800   hover:underline">Ajouter Offres</button>
    </div>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Montant</th>
                <th class="py-2 text-left">Delai</th>
                <th class="py-2 text-left">ID FreeLance</th>
                <th class="py-2 text-left">ID Projet</th>
                <th class="py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $Offres = $_SESSION['Offres'];
            if (!empty($Offres)): ?>
                <?php foreach ($Offres as $Offre): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= htmlspecialchars($Offre['id_offre']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($Offre['montant']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($Offre['delai']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($Offre['id_freelance']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($Offre['id_projet']); ?></td>
                        <td class="py-2 text-center">
                            <a href="delete.php?id=<?= $Offre['id_offre']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet projet ?');" class="text-red-500 hover:underline">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="py-4 text-center">Aucun Offre trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<section  id="Sous_Categories" class="bg-white p-4 rounded-lg  hidden cartSection overflow-auto h-72">
    <div  class="flex justify-between">
        <h2 class="text-lg font-semibold mb-4">Tous les Sous Categories</h2>
        <button onclick="return addSousCategory()" class="text-sm mb-4 p-2 font-semibold rounded-lg bg-yellow-400 text-gray-800 hover:underline">Ajouter Sous Categorie</button>
    </div>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Nom de Sous Categorie</th>
                <th class="py-2 text-left">Nom de Categorie</th>
                <th class="py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $Sous_Categories = $_SESSION['Sous_Categories'];
            if (!empty($Sous_Categories)): ?>
                <?php foreach ($Sous_Categories as $Sous_Categorie): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= htmlspecialchars($Sous_Categorie['id_sous_categorie']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($Sous_Categorie['nom_sous_categorie']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($Sous_Categorie['nom_categorie']); ?></td>
                        <td class="py-2 text-center">
                            <form action="Controller/sousCategorieController.php" method="POST">
                                <input type="number" name="sous_categorie_id" value="<?= $Sous_Categorie['id_sous_categorie']; ?>" class="hidden">
                                <button type="submit" name="modifierSousCategoies" class="text-blue-500 hover:underline">Modifier</button>
                                <button type="submit" name="supprimerSousCategoies" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet Sous Categories ?');" class="text-red-500 hover:underline">Supprimer</button>
                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="py-4 text-center">Aucun Sous Categorie trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<section  id="temoignages" class="bg-white p-4 rounded-lg  hidden cartSection overflow-auto h-72">
    <div  class="flex justify-between">
        <h2 class="text-lg font-semibold mb-4">Tous les Temoignages</h2>
      <button class="text-sm mb-4 p-2 font-semibold rounded-lg bg-yellow-400 text-gray-800   hover:underline">Ajouter Temoignage</button>
    </div>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Nom Utilisateur</th>
                <th class="py-2 text-left">Email Utilisateur</th>
                <th class="py-2 text-left">Commentaire</th>
                <th class="py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $temoignages = $_SESSION['temoignages'];
            if (!empty($temoignages)): ?>
                <?php foreach ($temoignages as $temoignage): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= htmlspecialchars($temoignage['id_temoignage']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($temoignage['nom_utilisateur']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($temoignage['email']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($temoignage['commentaire']); ?></td>
                        <td class="py-2 text-center">
                            <form action="Controller/temoignagesController.php" method="POST">
                                <input type="number" name="id_temoignage" value="<?= htmlspecialchars($temoignage['id_temoignage']); ?>" class="hidden">
                                <button name="supprimerTemoignage" type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce temoignage ?');" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="py-4 text-center">Aucun Temoignage trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<section  id="Categories" class="bg-white p-4 rounded-lg  hidden cartSection overflow-auto h-72">
    <div  class="flex justify-between">
        <h2 class="text-lg font-semibold mb-4">Tous les Categories</h2>
        <button onclick="return addCategorieForm()" class="text-sm mb-4 p-2 font-semibold rounded-lg bg-yellow-400 text-gray-800 hover:underline">Ajouter Categorie</button>
    </div>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Nom</th>
                <th class="py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $Categories = $_SESSION['Categories'];
            if (!empty($Categories)): ?>
                <?php foreach ($Categories as $Categorie): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= htmlspecialchars($Categorie['id_categorie']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($Categorie['nom_categorie']); ?></td>
                        <td class="py-2 text-center">
                            <form action="Controller/categorieController.php" method="POST">
                                <input type="number" value="<?= $Categorie['id_categorie']; ?>" name="id_categorie" class="hidden">
                                <button name="modifierCategory" type="submit" class="text-blue-500 hover:underline">Modifier</button>
                                <button name="supprimerCategory" type="submit" class="text-red-500 hover:underline" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet Sous Categories ?');">Supprimer</button>

                            </form>
                            </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="py-4 text-center">Aucun Categorie trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
    <!-- Suggestions -->
    <!-- <section class="bg-gray-800 text-white p-6 rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h2>
        <p class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        <div class="flex mt-4">
          <button class="bg-[#ff5743] text-white py-2 px-4 rounded">More details</button>
        </div>
      </section> -->
  </main>
  </div>
</section>


<section id="sectionX" class="fixed hidden flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95">
        <div class="w-1/2 mx-auto bg-purple-400">
            <div class="card-container flex justify-end">
                <button name="hideElement" onclick="return hideSection('sectionX')">✖</button>
            </div>
        </div>
</section>


<?php if (isset($_GET['donnees'])):
    $donnees = json_decode($_GET['donnees'], true); ?>

    <section class="fixed flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95">
        <form action="Controller/userController.php" method="POST" class="text-white w-1/2 text-center ">
            <div class="mx-auto border-2 p-6 rounded-lg border-gray-400">
                <input type="text" name="id_user_modify" value="<?= htmlspecialchars($donnees['id_utilisateur']) ?>" class="hidden">
                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Nom Utilisateur </span> <span> : </span> </nav></h1>
                <input type="text" class="uppercase border-none m-2 rounded-md bg-transparent w-1/3 pl-1" value="<?= htmlspecialchars($donnees['nom_utilisateur']) ?>" readonly>
                <br>
                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Email Utilisateur </span> <span> : </span> </nav></h1>
                <input type="text" class="uppercase border-none m-2 rounded-md bg-transparent w-1/3 pl-1" value="<?= htmlspecialchars($donnees['email']) ?>" readonly>
                <br>
                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Role Utilisateur </span> <span> : </span> </nav></h1>
                <select name="new_user_role" id="" class="uppercase border-2 m-2 rounded-md border-gray-400 bg-black w-1/3">
                    <option value="<?= htmlspecialchars($donnees['user_role']) ?>"><?= htmlspecialchars($donnees['user_role']) ?></option>
                    <?php if($donnees['user_role'] == 'admin'): ?>
                    <option value="user">user</option>
                    <?php else: ?>
                    <option value="admin">admin</option>
                    <?php endif ?>
                </select>
            </div>
            <div class=" flex justify-between w-1/2 mx-auto mt-6">
                <button type="submit" name="modifierRole" class="border-2 border-gray-400 p-2 px-6 rounded-lg">Modiffier</button>
                <button type="submit" name="annuler" class="border-2 border-gray-400 p-2 px-6 rounded-lg">Annuler</button>

            </div>

        </form>
    </section>
<?php endif ?>





<?php if (isset($_GET['error'])): ?>
    <section id="new_user" class="fixed  flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95 ">
        <div class="card-container flex justify-end w-1/3 absolute top-8">
            <button name="hideElement" onclick="return hideSection('new_user')" class="text-white font-bold">✖</button>
        </div>
        <div id="register-form" class="container h-[93%] max-w-lg p-6 pl-16 bg-transparent shadow-r-md rounded-r-lg flex flex-col  justify-center ">
                <div class="flex flex-col items-center">
                    <img src="img/ItThinkBrain.png" alt="" class="w-1/5">
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"><span class="text-slate-400">welcome to </span><span class="text-[#FF5743]">It</span>Think</h2>
                </div>
    <div id="error-message" class="text-red-500 mb-4">
        <?php
            if ($_GET['error'] === 'email_deja_enregistre') {
                echo "Cet email est déjà enregistré.";
            } elseif ($_GET['error'] === 'une_erreur_est_survenue') {
                echo "Une erreur est survenue, veuillez réessayer.";
            }
            elseif ($_GET['error'] === 'missing_fields') {

                echo "veuillez remplir tous les champs.";
            }

        ?>
    </div>
<?php else: ?>
    <section id="new_user" class="fixed hidden flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95">
    <div class="card-container flex justify-end w-1/3 absolute top-8">
            <button name="hideElement" onclick="return hideSection('new_user')" class="text-white font-bold">✖</button>
        </div>
    <div id="register-form" class="container h-[93%] max-w-lg p-6 pl-16 bg-transparent shadow-r-md rounded-r-lg flex flex-col  justify-center ">
    <div class="flex flex-col items-center">
        <img src="img/ItThinkBrain.png" alt="" class="w-1/5">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"><span class="text-slate-400">welcome to </span><span class="text-[#FF5743]">It</span>Think</h2>
    </div>
<?php endif; ?>

            <form id="registerForm" action="Controller/userController.php" method="POST" onsubmit="return validateInscriptionForm()">
                <div class="mb-4">
                    <label for="user_name" class="block text-white font-medium mb-2">Nom complet :</label>
                    <input type="text" id="user_name" name="user_name" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="nameError" class="text-red-500 text-sm hidden">Veuillez entrer votre nom complet.</span>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-white font-medium mb-2">Email :</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="emailError" class="text-red-500 text-sm hidden">Veuillez entrer une adresse email valide.</span>
                </div>
                <div class="mb-4">
                <label for="password" class="block text-white font-medium mb-2">User Role :</label>

                    <Select name="user_role"  class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                        <option value="user">USER</option>
                        <option value="admin">ADMIN</option>
                    </Select>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-white font-medium mb-2">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="passwordError" class="text-red-500 text-sm hidden">Veuillez entrer un mot de passe (minimum 8 caractères).</span>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="block text-white font-medium mb-2">Confirmer le mot de passe :</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="confirmPasswordError" class="text-red-500 text-sm hidden">Les mots de passe ne correspondent pas.</span>
                </div>
                <div class="flex justify-center">
                    <button onclick="return validateInscriptionForm()" type="submit" name="adminAddUser" class="bg-fuchsia-400 font-bold px-4 py-2 rounded-md hover:bg-slate-400 " >Ajouter</button>
                </div>
            </form>
        </div>
</section>

<section id="addprojet"  class="fixed hidden flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95 text-white">
    <div class="card-container flex justify-end w-1/3 absolute top-8">
            <button name="hideElement" onclick="return hideSection('addprojet')" class="text-white font-bold">✖</button>
        </div>
    <div class="flex flex-col justify-end w-1/3 top-8">
        <div class="flex flex-col items-center">
            <img src="img/ItThinkBrain.png" alt="" class="w-1/5">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"><span class="text-slate-400">Ajouter Projet</h2>
        </div>
        <form action="Controller/projetController.php" method="POST">
            <label class="block text-white font-medium mb-2" for="title">Titre de Projet</label>
            <input class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300 text-black" type="text" id="title" name="title" required>
            <label class="block text-white font-medium mb-2" for="description">Description</label>
            <textarea class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300  text-black" id="description" name="description" rows="4" required></textarea>
            

            <label class="block text-white font-medium mb-2" for="category">Categories</label>
            <select class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300 text-black" id="category" name="category" required>
                <?php
                if(isset($_SESSION['Categories'])):
                    $Categories = $_SESSION['Categories'];
                    if (!empty($Categories)): ?>
                        <?php foreach ($Categories as $Categorie): ?>
                            <option value="<?= htmlspecialchars($Categorie['id_categorie']) ?>">
                                <?= htmlspecialchars($Categorie['nom_categorie']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </select>
            <label class="block text-white font-medium mb-2" for="subcategory">Sous Categories</label>
            <select class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300 text-black" id="subcategory" name="subcategory" required>
                <?php
                if(isset($_SESSION['Sous_Categories'])):
                    $Sous_Categories = $_SESSION['Sous_Categories'];
                    if (!empty($Sous_Categories)): ?>
                        <?php foreach ($Sous_Categories as $Sous_Categorie): ?>
                            <option value="<?= htmlspecialchars($Sous_Categorie['id_sous_categorie']) ?>">
                                <?= htmlspecialchars($Sous_Categorie['nom_sous_categorie']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </select>

            <div class="flex justify-center">
            <button name="Ajouter_Projet" type="submit" class="bg-fuchsia-400 font-bold px-4 py-2 rounded-md hover:bg-slate-400 mt-4">Ajouter</button>
            </div>
        </form>
    </div>
</section>






<?php if (isset($_GET['project_data'])):
    $project_data = json_decode($_GET['project_data'], true); ?>

    <section class="fixed flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95">
        <form action="Controller/projetController.php" method="POST" class="text-white w-1/2 text-center ">
            <div class="mx-auto border-2 p-6 rounded-lg border-gray-400">
                <input type="text" name="id_projet" value="<?= htmlspecialchars($project_data['id_projet']) ?>" class="hidden">
                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Titre de Projet </span> <span> : </span> </nav></h1>
                <input type="text" name="name_projet_modify" class="uppercase border-none m-2 rounded-md bg-transparent w-1/3 pl-1" value="<?= htmlspecialchars($project_data['titre_projet']) ?>" readonly>
                <br>
                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Description </span> <span> : </span> </nav></h1>
                <input type="text" name="description_projet_modify" class="uppercase border-none m-2 rounded-md bg-transparent w-1/3 pl-1" value="<?= htmlspecialchars($project_data['description']) ?>" readonly>
                <br>
                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Categorie </span> <span> : </span> </nav></h1>
                <select name="category_projet_modify" id="" class="uppercase border-2 m-2 rounded-md border-gray-400 bg-black w-1/3">
                    <?php
                    $Categories = $_SESSION['Categories'];
                    if (!empty($Categories)): ?>
                        <?php foreach ($Categories as $Categorie): ?>
                            <option value="<?= htmlspecialchars($Categorie['id_categorie']) ?>">
                                <?= htmlspecialchars($Categorie['nom_categorie']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Statut de Projet </span> <span> : </span> </nav></h1>
                <select name="status_selected" id="" class="uppercase border-2 m-2 rounded-md border-gray-400 bg-black w-1/3">
                    <option value="En cours">En cours</option>
                    <option value="Fini">Fini</option>
                </select>

                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Sous Categorie </span> <span> : </span> </nav></h1>

                <select name="subcategory_projet_modify" id="" class="uppercase border-2 m-2 rounded-md border-gray-400 bg-black w-1/3">
                    <?php
                    if(isset($_SESSION['Sous_Categories'])):
                        $Sous_Categories = $_SESSION['Sous_Categories'];
                        if (!empty($Sous_Categories)): ?>
                            <?php foreach ($Sous_Categories as $Sous_Categorie): ?>
                                <option value="<?= htmlspecialchars($Sous_Categorie['id_sous_categorie']) ?>">
                                    <?= htmlspecialchars($Sous_Categorie['nom_sous_categorie']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </select>

            </div>
            <div class=" flex justify-between w-1/2 mx-auto mt-6">
                <button type="submit" name="modifierProject" class="border-2 border-gray-400 p-2 px-6 rounded-lg">Modiffier</button>
                <button type="submit" name="annuler" class="border-2 border-gray-400 p-2 px-6 rounded-lg">Annuler</button>

            </div>

        </form>
    </section>
<?php endif ?>



<?php if (isset($_GET['category_data'])):
    $category_data = json_decode($_GET['category_data'], true); ?>

    <section class="fixed flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95">
        <form action="Controller/categorieController.php" method="POST" class="text-white w-1/2 text-center ">
            <div class="mx-auto border-2 p-6 rounded-lg border-gray-400">
                <input type="text" name="id_categorie" value="<?= htmlspecialchars($category_data['id_categorie']) ?>" class="hidden">
                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Nom Categorie </span> <span> : </span> </nav></h1>
                <input type="text" name="name_category_modify" class="uppercase border-2 m-2 rounded-md bg-transparent w-1/3 pl-1" value="<?= htmlspecialchars($category_data['nom_categorie']) ?>">
       


            </div>
            <div class=" flex justify-between w-1/2 mx-auto mt-6">
                <button type="submit" name="confirmModifierCategory" class="border-2 border-gray-400 p-2 px-6 rounded-lg">Modiffier</button>
                <button type="submit" name="annuler" class="border-2 border-gray-400 p-2 px-6 rounded-lg">Annuler</button>

            </div>

        </form>
    </section>
<?php endif ?>



<?php if (isset($_GET['sous_category_data'])):
    $sous_category_data = json_decode($_GET['sous_category_data'], true); ?>

    <section class="fixed flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95">
        <form action="Controller/sousCategorieController.php" method="POST" class="text-white w-1/2 text-center ">
            <div class="mx-auto border-2 p-6 rounded-lg border-gray-400">
                <input type="text" name="sous_categorie_id" value="<?= htmlspecialchars($sous_category_data['id_sous_categorie']) ?>" class="hidden">
                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Nom Sous Categorie </span> <span> : </span> </nav></h1>
                <input type="text" name="name_souscategory_modify" class="uppercase border-2 m-2 rounded-md bg-transparent w-1/3 pl-1" value="">

                <h1 class="uppercase w-1/3 inline-block"><nav class="flex justify-between w-full"><span>Nom Categorie </span> <span> : </span> </nav></h1>

                <select class="w-1/3 p-2 border rounded-md focus:ring focus:ring-indigo-300 text-white inline-block bg-black" id="category" name="select_category_sousCat" required>
                <?php
                if(isset($_SESSION['Categories'])):
                    $Categories = $_SESSION['Categories'];
                    if (!empty($Categories)): ?>
                        <?php foreach ($Categories as $Categorie): ?>
                            <option value="<?= htmlspecialchars($Categorie['id_categorie']) ?>">
                                <?= htmlspecialchars($Categorie['nom_categorie']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </select>
            </div>
            <div class=" flex justify-between w-1/2 mx-auto mt-6">
                <button type="submit" name="confirmModifierSousCategory" class="border-2 border-gray-400 p-2 px-6 rounded-lg">Modiffier</button>
                <button type="submit" name="annuler" class="border-2 border-gray-400 p-2 px-6 rounded-lg">Annuler</button>

            </div>

        </form>
    </section>
<?php endif ?>





<section id="addFreeLance"  class="fixed hidden flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95 text-white">
    <div class="card-container flex justify-end w-1/3 absolute top-8">
            <button name="hideElement" onclick="return hideSection('addFreeLance')" class="text-white font-bold">✖</button>
        </div>
    <div class="flex flex-col justify-end w-1/3 top-8">
        <div class="flex flex-col items-center">
            <img src="img/ItThinkBrain.png" alt="" class="w-1/5">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"><span class="text-slate-400">Ajouter FreeLance</h2>
        </div>
        <form action="Controller/freeLanceController.php" method="POST">
            <label class="block text-white font-medium mb-2" for="user">Utilisateur</label>
            <select class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300 text-black" id="user" name="user_select" required>
                <?php
                if(isset($_SESSION['users'])):
                    $users = $_SESSION['users'];
                    if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($user['id_utilisateur']) ?>">
                                <?= htmlspecialchars($user['nom_utilisateur']) ?> : 
                                <?= htmlspecialchars($user['email']) ?> 
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </select>

            <label class="block text-white font-medium mb-2" for="competences">Les Competences de FreeLance</label>
            <textarea class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300  text-black" id="competences" name="competences" rows="4" required></textarea>
            


            <div class="flex justify-center">
            <button name="Ajouter_FreeLance" type="submit" class="bg-fuchsia-400 font-bold px-4 py-2 rounded-md hover:bg-slate-400 mt-4">Ajouter</button>
            </div>
        </form>
    </div>
</section>




<section id="addCategorie"  class="fixed hidden flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95 text-white">
    <div class="card-container flex justify-end w-1/3 absolute top-8">
            <button name="hideElement" onclick="return hideSection('addCategorie')" class="text-white font-bold">✖</button>
        </div>
    <div class="flex flex-col justify-end w-1/3 top-8">
        <div class="flex flex-col items-center">
            <img src="img/ItThinkBrain.png" alt="" class="w-1/5">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"><span class="text-slate-400">Ajouter Categorie</h2>
        </div>
        <form action="Controller/categorieController.php" method="POST">
            <label class="block text-white font-medium mb-2" for="user">Le Nom de Categorie</label>
            <input class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300 text-black" type="text" id="title" name="nom_categorie" required>

            <div class="flex justify-center">
            <button name="Ajouter_Categorie" type="submit" class="bg-fuchsia-400 font-bold px-4 py-2 rounded-md hover:bg-slate-400 mt-4">Ajouter</button>
            </div>
        </form>
    </div>
</section>



<section id="addSousCategory"  class="fixed hidden flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95 text-white">
    <div class="card-container flex justify-end w-1/3 absolute top-8">
            <button name="hideElement" onclick="return hideSection('addSousCategory')" class="text-white font-bold">✖</button>
        </div>
    <div class="flex flex-col justify-end w-1/3 top-8">
        <div class="flex flex-col items-center">
            <img src="img/ItThinkBrain.png" alt="" class="w-1/5">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"><span class="text-slate-400">Ajouter Sous Categorie</h2>
        </div>
        <form action="Controller/sousCategorieController.php" method="POST">
            <label class="block text-white font-medium mb-2" for="user">Le Nom de Sous Categorie</label>
            <input class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300 text-black" type="text" id="title" name="nom_sous_categorie" required>
            <label class="block text-white font-medium mb-2" for="category">Selectionner le Categorie</label>
            <select class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300 text-black" id="category" name="select_category" required>
                <?php
                if(isset($_SESSION['Categories'])):
                    $Categories = $_SESSION['Categories'];
                    if (!empty($Categories)): ?>
                        <?php foreach ($Categories as $Categorie): ?>
                            <option value="<?= htmlspecialchars($Categorie['id_categorie']) ?>">
                                <?= htmlspecialchars($Categorie['nom_categorie']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </select>
            <div class="flex justify-center">
            <button name="Ajouter_Sous_Categorie" type="submit" class="bg-fuchsia-400 font-bold px-4 py-2 rounded-md hover:bg-slate-400 mt-4">Ajouter</button>
            </div>
        </form>
    </div>
</section>



















<?php if (isset($_GET['page'])) :?>
    <script>
        const element = document.getElementById("<?= htmlspecialchars($_GET['page']) ?>");
        const allElements = document.getElementsByClassName("cartSection");
        for (let i = 0; i < allElements.length; i++) {
        allElements[i].classList.add("hidden");
    }
    element.classList.remove("hidden");
    </script>
<?php endif; ?>

<script>
    function new_user_form(){
        document.getElementById('new_user').classList.remove('hidden');
    }
    function addprojetForm(){
        document.getElementById('addprojet').classList.remove('hidden');
    }
    function addFreeLance(){
        document.getElementById('addFreeLance').classList.remove('hidden');
    }
    function addCategorieForm(){
        document.getElementById('addCategorie').classList.remove('hidden');
    }
    function addSousCategory(){
        document.getElementById('addSousCategory').classList.remove('hidden');
    }
    function hideSection(sec){
        const section = document.getElementById(sec);
        section.classList.add("hidden");
        if(sec == "new_user"){
            window.location.href = "admin.php";
        }
        if(sec == "addprojet"){
            gestion('projets');
        }
    }

    function showSection(element, info) {
    const section = document.getElementById("sectionX");
    let container = "";

    section.classList.remove("hidden");

    if (element === "description") {
        container = `<div class="w-1/2 mx-auto pb-4">${info}</div>`;
    }
    else if(element = "notification"){
        container = `<div class="w-1/2 mx-auto pb-4">${info}</div>`
    }
    section.innerHTML = `
        <div class="w-1/2 mx-auto bg-transparent ">
            <div class="text-white border-2 border-gray-700 p-4 rounded-lg w-full">
                <div class="card-container flex justify-end">
                    <button name="hideElement" onclick="return hideSection('sectionX')" class="text-white font-bold">✖</button>
                </div>
                ${container}
            </div>
        </div>
    `;
}



function validateLoginForm() {
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    let isValid = true;
    emailError.classList.add("hidden");
    passwordError.classList.add("hidden");

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!email.value.trim() || !emailPattern.test(email.value)) {
        emailError.classList.remove("hidden");
        isValid = false;
    }

    if (!password.value.trim()) {
        passwordError.classList.remove("hidden");
        isValid = false;
    }

    return isValid;
}

function validateInscriptionForm() {
    // Récupérer les champs du formulaire
    const fullName = document.getElementById("full_name");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");

    // Récupérer les messages d'erreur
    const nameError = document.getElementById("nameError");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");

    let isValid = true;

    // Réinitialiser les messages d'erreur
    nameError.classList.add("hidden");
    emailError.classList.add("hidden");
    passwordError.classList.add("hidden");
    confirmPasswordError.classList.add("hidden");

    // Validation du nom complet
    if (!fullName.value.trim()) {
        nameError.classList.remove("hidden");
        isValid = false;
    }

    // Validation de l'email
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!email.value.trim() || !emailPattern.test(email.value)) {
        emailError.classList.remove("hidden");
        isValid = false;
    }

    // Validation du mot de passe
    if (!password.value.trim() || password.value.length < 8) {
        passwordError.classList.remove("hidden");
        isValid = false;
    }

    // Validation de la confirmation du mot de passe
    if (password.value !== confirmPassword.value) {
        confirmPasswordError.classList.remove("hidden");
        isValid = false;
    }

    return isValid; // Empêche la soumission si le formulaire n'est pas valide
}



function gestion(ele){
    // const element = document.getElementById(ele);
    // const allElements = document.getElementsByClassName("cartSection");
    // for (let i = 0; i < allElements.length; i++) {
    //     allElements[i].classList.add("hidden");
    // }
    // element.classList.remove("hidden");

    window.location.href = `admin.php?page=${ele}`;

}



</script>
</body>
</html>
