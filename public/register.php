<?php
require_once "../includes/auth.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $errors[] = "Fill in all fields";
    } else {
        global $users;

        foreach ($users as $u) {
            if ($u['username'] === $username) {
                $errors[] = "This login is already taken";
                break;
            }
        }

        if (!$errors) {
            $id   = count($users) + 1;
            $role = empty($users) ? 'admin' : 'user';

            $users[] = [
                'id'       => $id,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role'     => $role,
            ];

            save_users($users);

            $_SESSION['user'] = [
                'id'       => $id,
                'username' => $username,
                'role'     => $role,
            ];

            header("Location: catalog.php");
            exit;
        }
    }
}

include("../includes/header.php");
?>

<h2>Register</h2>

<?php foreach ($errors as $e): ?>
  <p style="color:red;"><?= htmlspecialchars($e) ?></p>
<?php endforeach; ?>

<form method="post">
  <input type="text" name="username" placeholder="Login" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Register</button>
</form>

<p>Already have an account? <a href="login.php">Login</a></p>

<?php include("../includes/footer.php"); ?>