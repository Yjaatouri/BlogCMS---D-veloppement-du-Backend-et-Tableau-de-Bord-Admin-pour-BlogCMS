<?php
require_once 'functions/auth.php'; if (!isAdmin()) redirect('login.php');
require_once 'config/db.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM comments WHERE id = ?")->execute([$id]);
}

$comments = $pdo->query("SELECT c.*, p.title FROM comments c JOIN posts p ON c.post_id = p.id ORDER BY c.created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Commentaires - BlogCMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    <aside class="w-64 bg-indigo-800 text-white flex flex-col">
      <div class="p-6 text-2xl font-bold">BlogCMS Admin</div>
      <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="dashboard.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Dashboard</a>
        <a href="categories.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Catégories</a>
        <a href="comments.php" class="block px-4 py-3 bg-indigo-900 rounded-lg">Commentaires</a>
        <a href="my-articles.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Mes articles</a>
        <a href="index.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Voir le site</a>
      </nav>
      <div class="p-4">
        <a href="logout.php" class="block px-4 py-3 text-red-300 hover:bg-red-900 rounded-lg">Déconnexion</a>
      </div>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
      <h1 class="text-3xl font-bold mb-8">Modération des commentaires</h1>
      <div class="bg-white rounded-xl shadow-md p-6 space-y-6">
        <?php foreach ($comments as $c): ?>
          <div class="border-b pb-6 hover:bg-gray-50 p-4 rounded-lg">
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <p class="font-semibold"><?= htmlspecialchars($c['author_name']) ?></p>
                <p class="text-sm text-gray-500">Sur l'article : "<?= htmlspecialchars($c['title']) ?>" – <?= date('d M Y', strtotime($c['created_at'])) ?></p>
                <p class="mt-3 text-gray-700"><?= htmlspecialchars(substr($c['content'], 0, 150)) ?>...</p>
              </div>
              <div class="ml-6 space-y-2">
                <a href="?delete=<?= $c['id'] ?>" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Supprimer</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </main>
  </div>
</body>
</html>