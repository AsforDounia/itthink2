<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/script.js"></script>
    <style>
        #loginbg{
            background-image: url('img/Background.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            width: 100%;
            aspect-ratio: 1;
            color: #151313
                    #ff5743
                    #be94f5
                    #fccc42
                    #f7f7f5;
        }
    </style>
</head>
<body class="bg-gray-100">
    <section class="flex flex items-center justify-center h-screen">
        <div id="" class="h-[93%] max-w-md bg-white shadow-l-md rounded-l-lg relative">
            <img src="img/Background2.png" class="w-full h-full object-cover" alt="background">
            <div class="w-full h-full flex flex-col items-end absolute top-0   justify-center gap-1 left-[0.1%]">
                <div class="bg-fuchsia-400 h-[10%] w-1/3 rounded-l-2xl flex flex-col items-center justify-center font-bold hover:bg-slate-400 cursor-pointer" onclick="window.location.href='index.php'" >Connexion</div>
                <div class="text-white h-[10%] w-1/3 rounded-l-2xl flex flex-col items-center justify-center font-bold hover:bg-slate-400 cursor-pointer" onclick="window.location.href='inscription.php'">Inscription</div>
            </div>
        </div>

        <div id="login-form" class="container h-[93%] max-w-lg p-6 pl-16 bg-white shadow-r-md rounded-r-lg flex flex-col  justify-center ">
            <div class="flex flex-col items-center relative -top-12">
                <img src="img/ItThinkBrain.png" alt="" class="w-1/5">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"><span class="text-slate-400">welcome to </span><span class="text-[#FF5743]">It</span>Think</h2>
            </div>
            <?php if (isset($_GET['message'])):
                        if ($_GET['message'] === 'identifiants_incorrects') {
                            ?>
                            <div id="error-message" class="text-red-500 mb-8">
                            <?php
                            echo "Identifiants incorrects.";
                        }
                        else if ($_GET['message'] === 'inscription_reussie') {
                            ?>
                            <div id="error-message" class="text-green-500 mb-8">
                            <?php
                            echo "Inscription réussie. Vous pouvez se connecter.";
                        }
                    ?>
                </div>
            <?php endif; ?>
            <form id="loginForm" action="login.php" method="POST" onsubmit="return validateLoginForm()">
                <div class="mb-8">
                    <label for="email" class="block text-gray-700 font-medium mb-4">Email :</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="emailError" class="text-red-500 text-sm hidden">Veuillez entrer une adresse email valide.</span>
                </div>
                <div class="mb-8">
                    <label for="password" class="block text-gray-700 font-medium mb-4">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="passwordError" class="text-red-500 text-sm hidden">Veuillez entrer un mot de passe.</span>
                </div>
                <div class="flex justify-center">
                    <button type="submit" name="login" class="bg-fuchsia-400 font-bold px-4 py-2 rounded-md hover:bg-slate-400 ">Connexion</button>
                </div>
            </form>
            <div class="text-center mt-4">
                <a href="inscription.php" class="text-slate-400 hover:text-fuchsia-400 hover:underline">Créer un compte</a>
            </div>
        </div>
    </section>

</body>
</html>
