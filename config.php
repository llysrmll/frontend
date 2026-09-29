<?php
session_start();

function redirect($path) {
    header('Location: ' . $path);
    exit;
}

function isLoggedIn() {
    return !empty($_SESSION['user']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('index.php');
    }
}

function getUsers() {
    $file = __DIR__ . '/users.json';
    if (!file_exists($file)) {
        return [];
    }

    $content = file_get_contents($file);
    if ($content === false || trim($content) === '') {
        return [];
    }

    $data = json_decode($content, true);
    return is_array($data) ? $data : [];
}

function saveUsers($users) {
    $file = __DIR__ . '/users.json';
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function currentUser() {
    return $_SESSION['user'] ?? null;
}
?>
