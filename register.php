<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || $email === '' || $password === '') {
        flash_set('error', 'All fields are required.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash_set('error', 'Please enter a valid email address.');
    } elseif (strlen($username) < 3) {
        flash_set('error', 'Username must be at least 3 characters.');
    } elseif (strlen($password) < 6) {
        flash_set('error', 'Password must be at least 6 characters.');
    } else {
        try {
            $conn = db();
            $conn->begin_transaction();

            $check = $conn->prepare('SELECT 1 FROM users WHERE username = ? OR email = ?');
            $check->bind_param('ss', $username, $email);
            $check->execute();
            $check->store_result();
            if ($check->num_rows > 0) {
                $conn->rollback();
                flash_set('error', 'Username or email already exists.');
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $ins = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
                $ins->bind_param('sss', $username, $email, $hash);
                $ins->execute();
                $conn->commit();

                flash_set('success', 'Registration successful. Please login.');
                header('Location: login.php');
                exit;
            }
        } catch (Throwable $e) {
            if (isset($conn) && $conn instanceof mysqli) {
                try { $conn->rollback(); } catch (Throwable) { /* ignore */ }
            }
            flash_set('error', 'Registration failed. Please try again.');
        }
    }
}

$pageTitle = 'Register';
require_once __DIR__ . '/includes/header.php';
?>

<div class="form-wrap">
    <div class="form-card">
        <h1 style="margin:0 0 6px;">Register</h1>
        <div class="subtle">Create your account to book rooms.</div>

        <form method="post" action="register.php">
            <div class="field">
                <label>Username</label>
                <input type="text" name="username" placeholder="e.g. preet123" required>
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" placeholder="e.g. you@example.com" required>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" placeholder="min 6 characters" required>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Create Account</button>
                <a class="muted-link" href="login.php">Already have an account? Login</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

