<?php
require_once 'functions/auth.php'; if (!isLoggedIn()) redirect('login.php');
require_once 'config/db.php';
$users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$posts = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$comments = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - BlogCMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-indigo-800 text-white flex flex-col">
      <div class="p-6 text-2xl font-bold">BlogCMS Admin</div>
      <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="dashboard.php" class="block px-4 py-3 bg-indigo-900 rounded-lg">Dashboard</a>
        <a href="categories.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Catégories</a>
        <a href="comments.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Commentaires</a>
        <a href="my-articles.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Mes articles</a>
        <a href="index.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Voir le site</a>
      </nav>
      <div class="p-4">
        <a href="logout.php" class="block px-4 py-3 text-red-300 hover:bg-red-900 rounded-lg">Déconnexion</a>
      </div>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
      <h1 class="text-3xl font-bold mb-8">Tableau de bord</h1>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="text-lg font-semibold text-gray-700">Articles</h3>
          <p class="text-4xl font-bold text-indigo-600"><?= $posts ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="text-lg font-semibold text-gray-700">Commentaires</h3>
          <p class="text-4xl font-bold text-indigo-600"><?= $comments ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md">
          <h3 class="text-lg font-semibold text-gray-700">Utilisateurs</h3>
          <p class="text-4xl font-bold text-indigo-600"><?= $users ?></p>
        </div>
      </div>
    </main>
  </div>
</body>
</html>