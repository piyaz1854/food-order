<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usersFile = __DIR__ . "/../data/users.json";

if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([], JSON_PRETTY_PRINT));
}

$users = json_decode(file_get_contents($usersFile), true);
if (!is_array($users)) {
    $users = [];
}

function save_users(array $updatedUsers): void {
    global $usersFile;
    file_put_contents($usersFile, json_encode($updatedUsers, JSON_PRETTY_PRINT));
}

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool {
    return isset($_SESSION['user']);
}

function is_admin(): bool {
    return is_logged_in() && (($_SESSION['user']['role'] ?? '') === 'admin');
}