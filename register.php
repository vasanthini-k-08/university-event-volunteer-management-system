<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) redirect('dashboard.php');
$pageTitle = 'Volunteer Registration';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $studentNo = trim($_POST['student_no'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Enter a valid name and email. Password must contain at least 8 characters.';
    } else {
        $check = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $check->execute([$email]);
        if ($check->fetch()) $error = 'This email is already registered.';
        else {
            $stmt = $pdo->prepare("INSERT INTO users (name,email,student_no,department,password,role) VALUES (?,?,?,?,?,'student')");
            $stmt->execute([$name,$email,$studentNo,$department,password_hash($password, PASSWORD_DEFAULT)]);
            flash('Registration successful. Please log in.');
            redirect('login.php');
        }
    }
}
require __DIR__ . '/includes/header.php';
?>
<div class="auth-wrap"><form class="form-card" method="post">
  <span class="eyebrow">JOIN THE COMMUNITY</span><h1>Create volunteer account</h1><p class="muted">Register with your student details to apply for events.</p>
  <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
  <label>Full name<input name="name" required value="<?= e($_POST['name'] ?? '') ?>"></label>
  <label>Student email<input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>"></label>
  <label>Student number<input name="student_no" value="<?= e($_POST['student_no'] ?? '') ?>"></label>
  <label>Department / Course<input name="department" value="<?= e($_POST['department'] ?? '') ?>"></label>
  <label>Password<input type="password" name="password" minlength="8" required></label>
  <button class="btn btn-primary btn-full">Create account</button>
  <p class="form-foot">Already registered? <a href="login.php">Login</a></p>
</form></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
