<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) redirect('dashboard.php');
$pageTitle = 'Login'; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id,name,email,password,role FROM users WHERE email=? AND is_active=1');
    $stmt->execute([$email]); $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        unset($user['password']); $_SESSION['user'] = $user;
        redirect('dashboard.php');
    } else $error = 'Invalid email or password.';
}
require __DIR__ . '/includes/header.php';
?>
<div class="auth-wrap"><form class="form-card" method="post">
  <span class="eyebrow">WELCOME BACK</span><h1>Login to your account</h1><p class="muted">Continue managing your volunteer journey.</p>
  <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
  <label>Email address<input type="email" name="email" required></label>
  <label>Password<input type="password" name="password" required></label>
  <button class="btn btn-primary btn-full">Login</button>
  <p class="form-foot">New volunteer? <a href="register.php">Create an account</a></p>
</form></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
