<?php
require_once "../includes/auth.php";

$errors = [];

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $errors[] = "Fill in all fields";
    } else {
        global $users;
        $found = null;

        foreach ($users as $u) {
            if ($u['username'] === $username) {
                $found = $u;
                break;
            }
        }

        if (!$found || !password_verify($password, $found['password'])) {
            $errors[] = "Incorrect login or password";
        } else {
            $_SESSION['user'] = [
                'id'       => $found['id'],
                'username' => $found['username'],
                'role'     => $found['role'],
            ];

            header("Location: catalog.php");
            exit;
        }
    }
}

include("../includes/header.php");
?>

<h2>Login</h2>

<?php foreach ($errors as $e): ?>
  <p style="color:red;"><?= htmlspecialchars($e) ?></p>
<?php endforeach; ?>

<form method="post">
  <input type="text" name="username" placeholder="Login" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
</form>

<p>No account? <a href="register.php">Register</a></p>

<?php include("../includes/footer.php"); ?>
