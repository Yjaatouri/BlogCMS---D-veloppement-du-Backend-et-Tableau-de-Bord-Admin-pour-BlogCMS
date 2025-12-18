<?php require_once 'functions/auth.php'; require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BlogCMS - Accueil</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
  <!-- Header -->
  <header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-3xl font-bold text-indigo-600"><a href="index.php">BlogCMS</a></h1>
      <div class="flex items-center space-x-6">
        <a href="index.php" class="text-gray-700 hover:text-indigo-600">Accueil</a>
        <?php if (isLoggedIn()): ?>
          <a href="dashboard.php" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
          <a href="logout.php" class="text-gray-700 hover:text-indigo-600">Déconnexion</a>
        <?php else: ?>
          <a href="login.php" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Connexion</a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <h2 class="text-5xl font-bold mb-6">Bienvenue sur BlogCMS</h2>
      <p class="text-xl mb-10">Découvrez des articles inspirants</p>
    </div>
  </section>

  <!-- Articles -->
  <section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-3xl font-bold mb-10 text-center">Derniers articles</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php
        $stmt = $pdo->query("SELECT p.*, u.username, c.name AS category FROM posts p 
                             JOIN users u ON p.user_id = u.id 
                             JOIN categories c ON p.category_id = c.id 
                             WHERE status = 'published' ORDER BY created_at DESC LIMIT 9");
        foreach ($stmt->fetchAll() as $post):
        ?>
          <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition">
            <img src="https://images.unsplash.com/photo-1501504905252-473a5b2b4b3e?w=800" alt="Article" class="w-full h-56 object-cover">
            <div class="p-6">
              <span class="text-xs font-semibold text-indigo-600 uppercase"><?= htmlspecialchars($post['category']) ?></span>
              <h3 class="text-xl font-bold mt-2"><a href="article.php?id=<?= $post['id'] ?>" class="hover:text-indigo-600"><?= htmlspecialchars($post['title']) ?></a></h3>
              <p class="text-gray-600 mt-2 line-clamp-3"><?= substr(strip_tags($post['content']), 0, 120) ?>...</p>
              <div class="flex items-center mt-4 text-sm text-gray-500">
                <span>Par <?= htmlspecialchars($post['username']) ?></span>
                <span class="mx-2">•</span>
                <span><?= date('d M Y', strtotime($post['created_at'])) ?></span>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <footer class="bg-gray-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p>&copy; 2025 BlogCMS. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>