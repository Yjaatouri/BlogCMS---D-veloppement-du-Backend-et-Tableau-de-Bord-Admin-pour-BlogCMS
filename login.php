<?php require_once 'functions/auth.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Connexion - BlogCMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">
  <div class="bg-white p-10 rounded-xl shadow-2xl w-full max-w-md">
    <h1 class="text-3xl font-bold text-indigo-600 text-center mb-8">BlogCMS</h1>
    <h2 class="text-2xl font-bold mb-6 text-center">Connexion</h2>

    <?php if (isset($_GET['admin_only'])): ?>
      <p class="text-red-600 text-center mb-6">Cette page est réservée aux administrateurs. Connectez-vous.</p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
      <p class="text-red-600 text-center mb-4">Identifiants incorrects</p>
    <?php endif; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-3 mb-4 border rounded-lg focus:ring-indigo-500">
      <input type="password" name="password" placeholder="Mot de passe" required class="w-full px-4 py-3 mb-6 border rounded-lg focus:ring-indigo-500">
      <button type="submit" name="login" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700">Se connecter</button>
    </form>
    <p class="text-center mt-6">Pas de compte ? <a href="register.php" class="text-indigo-600 hover:underline">S'inscrire</a></p>
  </div>
</body>

</html>
<?php
if (isset($_POST['login'])) {
  if (login($_POST['email'], $_POST['password'])) redirect('dashboard.php');
  else redirect('login.php?error=1');
}
?>