<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_login();
$user = current_user(); $role = $user['role']; $pageTitle = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>
<section class="page-heading"><span class="eyebrow"><?= e(strtoupper($role)) ?> PORTAL</span><h1>Hello, <?= e($user['name']) ?>.</h1><p>Here is your event volunteer workspace.</p></section>
<?php if ($role === 'admin'): ?>
<?php
$counts = [
 'events' => (int)$pdo->query('SELECT COUNT(*) FROM events')->fetchColumn(),
 'students' => (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='student'")->fetchColumn(),
 'pending' => (int)$pdo->query("SELECT COUNT(*) FROM volunteer_applications WHERE status='pending'")->fetchColumn()
];
?>
<div class="stats-grid"><div class="stat-card"><span>Total events</span><strong><?= $counts['events'] ?></strong></div><div class="stat-card"><span>Student volunteers</span><strong><?= $counts['students'] ?></strong></div><div class="stat-card"><span>Pending applications</span><strong><?= $counts['pending'] ?></strong></div></div>
<div class="section-head"><div><span class="eyebrow">ADMIN TOOLS</span><h2>Manage your system</h2></div></div>
<div class="action-grid"><a class="action-card" href="manage_events.php"><b>＋</b><strong>Manage events</strong><span>Create and update campus events</span></a><a class="action-card" href="applications.php"><b>✓</b><strong>Volunteer applications</strong><span>Review and approve applications</span></a><a class="action-card" href="tasks.php"><b>☷</b><strong>Task management</strong><span>Assign tasks to approved volunteers</span></a><a class="action-card" href="attendance.php"><b>◷</b><strong>Attendance</strong><span>Record volunteer attendance</span></a></div>
<?php elseif ($role === 'organizer'): ?>
<div class="action-grid"><a class="action-card" href="tasks.php"><b>☷</b><strong>Task management</strong><span>Assign tasks to volunteers</span></a><a class="action-card" href="attendance.php"><b>◷</b><strong>Attendance</strong><span>Record event attendance</span></a></div>
<?php else: ?>
<?php $stmt=$pdo->prepare("SELECT va.status,e.title,e.event_date FROM volunteer_applications va JOIN events e ON e.id=va.event_id WHERE va.student_id=? ORDER BY va.created_at DESC");$stmt->execute([$user['id']]);$apps=$stmt->fetchAll(); ?>
<div class="section-head"><div><span class="eyebrow">MY VOLUNTEERING</span><h2>My applications</h2></div><a class="btn btn-primary" href="events.php">Find events</a></div>
<div class="table-wrap"><table><thead><tr><th>Event</th><th>Date</th><th>Application status</th></tr></thead><tbody><?php foreach($apps as $a): ?><tr><td><?= e($a['title']) ?></td><td><?= e(date('d M Y',strtotime($a['event_date']))) ?></td><td><span class="status <?= e($a['status']) ?>"><?= e(ucfirst($a['status'])) ?></span></td></tr><?php endforeach; ?><?php if(!$apps): ?><tr><td colspan="3">You have not applied for any events yet.</td></tr><?php endif; ?></tbody></table></div>

<?php
$taskStmt = $pdo->prepare("SELECT t.task_title, t.description, t.status, e.title AS event_title, e.event_date FROM tasks t JOIN events e ON e.id=t.event_id WHERE t.student_id=? ORDER BY t.created_at DESC");
$taskStmt->execute([$user['id']]);
$tasks = $taskStmt->fetchAll();
?>
<div class="section-head" style="margin-top:40px;"><div><span class="eyebrow">MY TASKS</span><h2>My tasks</h2></div></div>
<div class="table-wrap"><table><thead><tr><th>Task</th><th>Event</th><th>Date</th><th>Description</th><th>Status</th></tr></thead><tbody><?php foreach($tasks as $t): ?><tr><td><?= e($t['task_title']) ?></td><td><?= e($t['event_title']) ?></td><td><?= e(date('d M Y',strtotime($t['event_date']))) ?></td><td><?= e($t['description']) ?></td><td><span class="status <?= e($t['status']) ?>"><?= e(ucfirst($t['status'])) ?></span></td></tr><?php endforeach; ?><?php if(!$tasks): ?><tr><td colspan="5">No tasks assigned yet.</td></tr><?php endif; ?></tbody></table></div>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
