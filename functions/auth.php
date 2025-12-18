<?php
session_start();
require_once __DIR__ . '/../config/db.php';

function login($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    return false;
}

function isLoggedIn() { return isset($_SESSION['user_id']); }
function isAdmin() { return isLoggedIn() && $_SESSION['role'] === 'admin'; }
function redirect($url) { header("Location: $url"); exit; }
?>