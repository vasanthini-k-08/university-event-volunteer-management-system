<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM events WHERE id=? AND status='published'");
$stmt->execute([$id]); $event = $stmt->fetch();
if (!$event) { http_response_code(404); exit('Event not found.'); }
require_login();
if (current_user()['role'] !== 'student') { flash('Only student accounts can apply for events.','error'); redirect('dashboard.php'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $check = $pdo->prepare('SELECT id FROM volunteer_applications WHERE event_id=? AND student_id=?');
    $check->execute([$id,current_user()['id']]);
    if ($check->fetch()) flash('You have already applied for this event.','error');
    else {
        $stmt = $pdo->prepare("INSERT INTO volunteer_applications (event_id,student_id,message,status) VALUES (?,?,?,'pending')");
        $stmt->execute([$id,current_user()['id'],trim($_POST['message'] ?? '')]);
        flash('Your volunteer application has been submitted.');
    }
    redirect("event.php?id={$id}");
}
$pageTitle = $event['title'];
require __DIR__ . '/includes/header.php';
?>
<section class="detail-card"><span class="eyebrow">EVENT DETAILS</span><h1><?= e($event['title']) ?></h1><p class="lead"><?= nl2br(e($event['description'])) ?></p><div class="detail-grid"><div><small>DATE</small><strong><?= e(date('d M Y',strtotime($event['event_date']))) ?></strong></div><div><small>VENUE</small><strong><?= e($event['venue']) ?></strong></div><div><small>VOLUNTEER PLACES</small><strong><?= (int)$event['volunteer_limit'] ?></strong></div></div>
<form method="post" class="apply-box"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><label>Why would you like to volunteer?<textarea name="message" rows="3" placeholder="Tell the organizer briefly..."></textarea></label><button class="btn btn-primary">Apply to volunteer</button></form></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
