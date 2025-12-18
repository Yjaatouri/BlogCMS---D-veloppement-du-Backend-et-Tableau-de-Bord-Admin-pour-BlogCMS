<?php require_once 'functions/auth.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - BlogCMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
  <div class="bg-white p-10 rounded-xl shadow-2xl w-full max-w-md">
    <h1 class="text-3xl font-bold text-indigo-600 text-center mb-8">BlogCMS</h1>
    <h2 class="text-2xl font-bold mb-6 text-center">Inscription</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Nom d'utilisateur" required class="w-full px-4 py-3 mb-4 border rounded-lg">
      <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-3 mb-4 border rounded-lg">
      <input type="password" name="password" placeholder="Mot de passe" required class="w-full px-4 py-3 mb-6 border rounded-lg">
      <button type="submit" name="register" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700">S'inscrire</button>
    </form>
  </div>
</body>
</html>
<?php
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, role, created_at) VALUES (?, ?, ?, 'user', NOW())");
    $stmt->execute([$username, $email, $password]);
    redirect('login.php');
}
?>