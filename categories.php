<?php
require_once 'functions/auth.php'; if (!isAdmin()) redirect('login.php');
require_once 'config/db.php';

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    $stmt->execute([$name, $desc]);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Catégories - BlogCMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    <aside class="w-64 bg-indigo-800 text-white flex flex-col">
      <div class="p-6 text-2xl font-bold">BlogCMS Admin</div>
      <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="dashboard.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Dashboard</a>
        <a href="categories.php" class="block px-4 py-3 bg-indigo-900 rounded-lg">Catégories</a>
        <a href="comments.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Commentaires</a>
        <a href="my-articles.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Mes articles</a>
        <a href="index.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Voir le site</a>
      </nav>
      <div class="p-4">
        <a href="logout.php" class="block px-4 py-3 text-red-300 hover:bg-red-900 rounded-lg">Déconnexion</a>
      </div>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
      <h1 class="text-3xl font-bold mb-8">Gestion des catégories</h1>

      <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Ajouter une catégorie</h2>
        <form method="POST" class="flex gap-4">
          <input type="text" name="name" placeholder="Nom" required class="flex-1 px-4 py-3 border rounded-lg">
          <input type="text" name="description" placeholder="Description" class="flex-1 px-4 py-3 border rounded-lg">
          <button type="submit" name="add" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700">Ajouter</button>
        </form>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Liste des catégories</h2>
        <table class="w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-3">Nom</th>
              <th class="py-3">Description</th>
              <th class="py-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $cat): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="py-3"><?= htmlspecialchars($cat['name']) ?></td>
                <td class="py-3"><?= htmlspecialchars($cat['description']) ?></td>
                <td class="py-3">
                  <a href="?delete=<?= $cat['id'] ?>" class="text-red-600 hover:underline">Supprimer</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>