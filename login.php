<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginType = (string)($_POST['login_type'] ?? 'user');
    $usernameOrEmail = trim((string)($_POST['username_or_email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($usernameOrEmail === '' || $password === '') {
        flash_set('error', 'Username/email and password are required.');
    } elseif ($loginType === 'admin') {
        $stmt = db()->prepare('SELECT username, password FROM admins WHERE username = ?');
        $stmt->bind_param('s', $usernameOrEmail);
        $stmt->execute();
        $stmt->bind_result($dbUsername, $hash);
        if ($stmt->fetch() && password_verify($password, (string)$hash)) {
            $_SESSION['admin_username'] = (string)$dbUsername;
            unset($_SESSION['username']);
            flash_set('success', 'Admin login successful.');
            header('Location: admin_home.php');
            exit;
        }
        flash_set('error', 'Invalid admin credentials. Please try again.');
    } else {
        $stmt = db()->prepare('SELECT username, password FROM users WHERE username = ? OR email = ?');
        $stmt->bind_param('ss', $usernameOrEmail, $usernameOrEmail);
        $stmt->execute();
        $stmt->bind_result($username, $hash);
        if ($stmt->fetch() && password_verify($password, (string)$hash)) {
            $_SESSION['username'] = (string)$username;
            unset($_SESSION['admin_username']);
            flash_set('success', 'Login successful.');
            header('Location: index.php');
            exit;
        }
        flash_set('error', 'Invalid credentials. Please try again.');
    }
}

$pageTitle = 'Login';
require_once __DIR__ . '/includes/header.php';
?>

<div class="form-wrap">
    <div class="form-card">
        <h1 style="margin:0 0 6px;">Login</h1>
        <div class="subtle">Login as user or admin from one form.</div>

        <form method="post" action="login.php">
            <div class="field">
                <label>Username or Email</label>
                <input type="text" name="username_or_email" placeholder="e.g. preet123 or you@example.com" required>
            </div>
            <div class="field">
                <label>Login Type</label>
                <select name="login_type" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" placeholder="your password" required>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Login</button>
                <a class="muted-link" href="register.php">Create account</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

