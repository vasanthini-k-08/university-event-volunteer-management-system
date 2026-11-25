<?php
require_once __DIR__ . '/config/database.php'; require_once __DIR__ . '/includes/functions.php';
require_role(['admin']); $pageTitle='Manage Events'; $error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 verify_csrf(); $action=$_POST['action']??'';
 if ($action==='create') {
  $title=trim($_POST['title']??''); $date=$_POST['event_date']??''; $venue=trim($_POST['venue']??''); $desc=trim($_POST['description']??''); $limit=max(1,(int)($_POST['volunteer_limit']??1)); $status=$_POST['status']==='draft'?'draft':'published';
  if($title && $date && $venue){$s=$pdo->prepare('INSERT INTO events(title,description,event_date,venue,volunteer_limit,status,created_by) VALUES(?,?,?,?,?,?,?)');$s->execute([$title,$desc,$date,$venue,$limit,$status,current_user()['id']]);flash('Event created.');redirect('manage_events.php');} else $error='Please complete the required fields.';
 }
 if($action==='delete'){ $s=$pdo->prepare('DELETE FROM events WHERE id=?');$s->execute([(int)$_POST['id']]);flash('Event deleted.');redirect('manage_events.php');}
}
$events=$pdo->query('SELECT * FROM events ORDER BY event_date DESC')->fetchAll(); require __DIR__.'/includes/header.php';
?>
<section class="page-heading"><span class="eyebrow">ADMIN</span><h1>Manage events</h1><p>Create and publish university events for student volunteers.</p></section>
<div class="split-layout"><form class="form-card" method="post"><h2>Create an event</h2><?php if($error):?><div class="alert error"><?=e($error)?></div><?php endif;?><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="create">
<label>Event title<input name="title" required></label><label>Description<textarea name="description" rows="4"></textarea></label><label>Event date<input type="date" name="event_date" required></label><label>Venue<input name="venue" required></label><label>Volunteer limit<input type="number" min="1" name="volunteer_limit" value="20"></label><label>Publication<select name="status"><option value="published">Published</option><option value="draft">Draft</option></select></label><button class="btn btn-primary">Create event</button></form>
<div><h2>Existing events</h2><div class="stack-list"><?php foreach($events as $ev):?><div class="list-card"><div><strong><?=e($ev['title'])?></strong><small><?=e(date('d M Y',strtotime($ev['event_date'])))?> · <?=e($ev['venue'])?> · <?=e($ev['status'])?></small></div><form method="post" onsubmit="return confirm('Delete this event and its related records?')"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$ev['id']?>"><button class="btn btn-danger btn-small">Delete</button></form></div><?php endforeach;?><?php if(!$events):?><div class="empty-state">No events created.</div><?php endif;?></div></div></div>
<?php require __DIR__.'/includes/footer.php';?>
