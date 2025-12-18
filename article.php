<?php
require_once 'functions/auth.php'; require_once 'config/db.php';
$post_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT p.*, u.username, c.name AS category FROM posts p 
                       JOIN users u ON p.user_id = u.id 
                       JOIN categories c ON p.category_id = c.id 
                       WHERE p.id = ? AND status = 'published'");
$stmt->execute([$post_id]);
$post = $stmt->fetch();
if (!$post) redirect('index.php');


if (isset($_POST['comment'])) {
    $author_name = $_POST['author_name'];
    $email = $_POST['email'];
    $content = $_POST['content'];
    $post_id = $_GET['id'];

    
    $stmt = $pdo->prepare("INSERT INTO comments (author_name, email, content, post_id, status, created_at) 
                           VALUES (?, ?, ?, ?, 'approved', NOW())");
    $stmt->execute([$author_name, $email, $content, $post_id]);

    
    header("Location: article.php?id=" . $post_id);
    exit;
}

$comments = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? AND status = 'approved' ORDER BY created_at DESC");
$comments->execute([$post_id]);
$comments = $comments->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($post['title']) ?> - BlogCMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
  <header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-3xl font-bold text-indigo-600"><a href="index.php">BlogCMS</a></h1>
      <nav class="space-x-6">
        <a href="index.php" class="text-gray-700 hover:text-indigo-600">Accueil</a>
        <?php if (isLoggedIn()): ?>
          <a href="dashboard.php" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <article class="max-w-4xl mx-auto px-4 py-12">
    <img src="https://images.unsplash.com/photo-1501504905252-473a5b2b4b3e?w=1200" alt="Article" class="w-full h-96 object-cover rounded-lg mb-8">
    <div class="bg-white rounded-lg shadow-md p-8">
      <span class="text-xs font-semibold text-indigo-600 uppercase"><?= htmlspecialchars($post['category']) ?></span>
      <h1 class="text-4xl font-bold mt-4 mb-6"><?= htmlspecialchars($post['title']) ?></h1>
      <div class="flex items-center text-sm text-gray-600 mb-8">
        <span>Par <?= htmlspecialchars($post['username']) ?></span>
        <span class="mx-4">•</span>
        <span><?= date('d M Y', strtotime($post['created_at'])) ?></span>
      </div>
      <div class="prose max-w-none text-lg text-gray-700 leading-relaxed">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
      </div>
    </div>

    <section class="mt-12 bg-white rounded-lg shadow-md p-8">
      <h2 class="text-2xl font-bold mb-6">Commentaires (<?= count($comments) ?>)</h2>
      <?php foreach ($comments as $c): ?>
        <div class="border-b pb-6 mb-6">
          <div class="flex items-start space-x-4">
            <div class="bg-gray-200 w-10 h-10 rounded-full flex items-center justify-center text-gray-600 font-bold">U</div>
            <div>
              <strong><?= htmlspecialchars($c['author_name']) ?></strong> 
              <span class="text-sm text-gray-500">– <?= date('d M Y', strtotime($c['created_at'])) ?></span>
              <p class="mt-2 text-gray-700"><?= nl2br(htmlspecialchars($c['content'])) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <form class="mt-10 space-y-4" method="POST">
        <input type="text" name="author_name" placeholder="Votre nom" required class="w-full px-4 py-3 border rounded-lg">
        <input type="email" name="email" placeholder="Votre email" required class="w-full px-4 py-3 border rounded-lg">
        <textarea name="content" placeholder="Votre commentaire..." rows="4" required class="w-full px-4 py-3 border rounded-lg"></textarea>
        <button type="submit" name="comment" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">Publier</button>
      </form>
    </section>
  </article>

  <footer class="bg-gray-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p>&copy; 2025 BlogCMS. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>