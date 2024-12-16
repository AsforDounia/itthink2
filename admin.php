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
  <script src="js/script.js"></script>
</head>
<body class="bg-black h-screen">
<section class="m-5">

  <!-- Container principal -->
  <div class="flex">
    <!-- Sidebar -->
    <aside class="w-20 bg-purple-400  flex flex-col items-center space-y-8 py-28 rounded-l-lg ">
      <div class="h-10 w-10 bg-white rounded-md"></div>
      <div class="h-10 w-10 bg-gray-800 rounded-md"></div>
      <div class="h-10 w-10 bg-gray-800 rounded-md"></div>
      <div class="h-10 w-10 bg-gray-800 rounded-md"></div>
      <div class="h-10 w-10 bg-gray-800 rounded-md"></div>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 p-8 rounded-r-lg bg-gray-100">
      <!-- Header -->
      <header class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="flex items-center space-x-4">
          <input type="text" placeholder="Search" class="border rounded-lg py-2 px-4">
          <div class="h-10 w-10 rounded-full bg-gray-300"></div>
        </div>
      </header>

      <!-- Section des cartes -->
      <section class="grid grid-cols-4 gap-6 mb-8">
        <div class="bg-yellow-200 px-4 py-8 px-4 py-8 rounded-lg text-center flex flex-col items-center cursor-pointer relative grouprelative group">
          <h2 class="text-xl font-semibold mb-4">Nombre total d'utilisateurs</h2>
          <div class="font-bold text-3xl"><?php echo count($_SESSION['users']) ;?></div>
          <button onclick="return gestion('users')" class="bg-yellow-200 p-2 rounded-md absolute w-full h-full top-0 hidden group-hover:block text-black text-xl font-bold">Gestion des Utilisateurs</button>
        </div>
        <div class="bg-purple-300 px-4 py-8 p-4 rounded-lg text-center flex flex-col items-center cursor-pointer relative group">
          <h2 class="text-xl font-semibold mb-4">Nombre de projets publiés</h2>
          <div class="font-bold text-3xl"><?php echo count($_SESSION['projets']) ; ?></div>
          <button onclick="return gestion('projets')" class="bg-purple-300 p-2 rounded-md absolute w-full h-full top-0 hidden group-hover:block text-black text-xl font-bold">Gestion des Projets</button>

        </div>
        <div class="bg-rose-100 px-4 py-8 p-4 rounded-lg text-center flex flex-col items-center cursor-pointer relative group">
          <h2 class="text-xl font-semibold mb-4">Nombre de freelances inscrits</h2>
          <div class="font-bold text-3xl"><?php echo count($_SESSION['FreeLances']) ; ?></div>
          <button onclick="return gestion('freelances')" class="bg-rose-100 p-2 rounded-md absolute w-full h-full top-0 hidden group-hover:block text-black text-xl font-bold">Gestion des Freelances</button>

        </div>
        <div class="bg-cyan-200 px-4 py-8 p-4 rounded-lg text-center flex flex-col items-center cursor-pointer relative group">
          <h2 class="text-xl font-semibold mb-4">Offres en cours</h2>
          <div class="font-bold text-3xl"><?php echo count($_SESSION['Offres']) ; ?></div>
          <button onclick="return gestion('Offres')" class="bg-cyan-200 p-2 rounded-md absolute w-full h-full top-0 hidden group-hover:block text-black text-xl font-bold">Gestion des Offres</button>

        </div>
      </section>

      <!-- Tableau des utilisateurs -->
  <section  id="users" class="bg-white p-4 rounded-lg mb-8 cartSection">
    <!-- <h2 class="text-lg font-semibold mb-4">Tous les utilisateurs</h2> -->
    <div  class="flex justify-between">
      <h2 class="text-xl font-semibold mb-4">Tous les utilisateurs</h2>
      <button class="text-sm mb-4 p-2 font-semibold rounded-lg bg-yellow-400 text-gray-800   hover:underline">Ajouter Utilisateur</button>
    </div>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Nom</th>
                <th class="py-2 text-left">Email</th>
                <th class="py-2 text-left">Rôle</th>
                <th class="py-2 text-right pr-12 ">Actions</th>
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
                        <td class="py-2 text-right">
                            <a href="edit.php?id=<?= $user['id_utilisateur']; ?>" class="text-blue-500 hover:underline">Modifier</a>
                            <span class="mx-1">|</span>
                            <a href="delete.php?id=<?= $user['id_utilisateur']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="text-red-500 hover:underline">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="py-4 text-center">Aucun utilisateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<section  id="projets" class="bg-white p-4 rounded-lg mb-8 hidden cartSection">
    <h2 class="text-lg font-semibold mb-4">Tous les Projets</h2>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Nom</th>
                <th class="py-2 text-left">Email</th>
                <th class="py-2 text-left">Rôle</th>
                <th class="py-2 text-right">Actions</th>
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
                        <td class="py-2 text-right">
                            <a href="edit.php?id=<?= $user['id_utilisateur']; ?>" class="text-blue-500 hover:underline">Modifier</a>
                            <span class="mx-1">|</span>
                            <a href="delete.php?id=<?= $user['id_utilisateur']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="text-red-500 hover:underline">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="py-4 text-center">Aucun utilisateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<section  id="freelances" class="bg-white p-4 rounded-lg mb-8 hidden cartSection">
    <h2 class="text-lg font-semibold mb-4">Tous les freelances</h2>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Nom</th>
                <th class="py-2 text-left">Email</th>
                <th class="py-2 text-left">Rôle</th>
                <th class="py-2 text-right">Actions</th>
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
                        <td class="py-2 text-right">
                            <a href="edit.php?id=<?= $user['id_utilisateur']; ?>" class="text-blue-500 hover:underline">Modifier</a>
                            <span class="mx-1">|</span>
                            <a href="delete.php?id=<?= $user['id_utilisateur']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="text-red-500 hover:underline">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="py-4 text-center">Aucun utilisateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<section  id="Offres" class="bg-white p-4 rounded-lg mb-8 hidden cartSection">
    <h2 class="text-lg font-semibold mb-4">Tous les Offres</h2>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Nom</th>
                <th class="py-2 text-left">Email</th>
                <th class="py-2 text-left">Rôle</th>
                <th class="py-2 text-right">Actions</th>
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
                        <td class="py-2 text-right">
                            <a href="edit.php?id=<?= $user['id_utilisateur']; ?>" class="text-blue-500 hover:underline">Modifier</a>
                            <span class="mx-1">|</span>
                            <a href="delete.php?id=<?= $user['id_utilisateur']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="text-red-500 hover:underline">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="py-4 text-center">Aucun utilisateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

      <!-- Suggestions -->
      <section class="bg-gray-800 text-white p-6 rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h2>
        <p class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        <div class="flex mt-4">
          <button class="bg-[#ff5743] text-white py-2 px-4 rounded">More details</button>
        </div>
      </section>
  </main>
  </div>
  </section>

</body>
</html>
