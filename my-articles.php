<?php
require_once 'functions/auth.php'; if (!isLoggedIn()) redirect('login.php');
require_once 'config/db.php';
$user_id = $_SESSION['user_id'];

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id, category_id, status) VALUES (?, ?, ?, ?, 'draft')");
    $stmt->execute([$title, $content, $user_id, $category_id]);
}

$posts = $pdo->prepare("SELECT p.*, c.name AS category FROM posts p JOIN categories c ON p.category_id = c.id WHERE user_id = ?");
$posts->execute([$user_id]);
$posts = $posts->fetchAll();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Mes Articles - BlogCMS</title>
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
        <a href="comments.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Commentaires</a>
        <a href="my-articles.php" class="block px-4 py-3 bg-indigo-900 rounded-lg">Mes articles</a>
        <a href="index.php" class="block px-4 py-3 hover:bg-indigo-700 rounded-lg">Voir le site</a>
      </nav>
      <div class="p-4">
        <a href="logout.php" class="block px-4 py-3 text-red-300 hover:bg-red-900 rounded-lg">Déconnexion</a>
      </div>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
      <h1 class="text-3xl font-bold mb-8">Mes Articles</h1>

      <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Nouvel article</h2>
        <form method="POST" class="space-y-4">
          <input type="text" name="title" placeholder="Titre" required class="w-full px-4 py-3 border rounded-lg">
          <textarea name="content" rows="6" placeholder="Contenu" required class="w-full px-4 py-3 border rounded-lg"></textarea>
          <select name="category_id" class="w-full px-4 py-3 border rounded-lg">
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" name="add" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">Enregistrer (brouillon)</button>
        </form>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Mes articles</h2>
        <table class="w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-3">Titre</th>
              <th class="py-3">Catégorie</th>
              <th class="py-3">Statut</th>
              <th class="py-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($posts as $post): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="py-3"><?= htmlspecialchars($post['title']) ?></td>
                <td class="py-3"><?= htmlspecialchars($post['category']) ?></td>
                <td class="py-3"><?= $post['status'] ?></td>
                <td class="py-3">
                  <a href="?delete=<?= $post['id'] ?>" class="text-red-600 hover:underline">Supprimer</a>
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
<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    redirect('my-articles.php');
}
?>