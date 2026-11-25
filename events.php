<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Events';
$events = $pdo->query("SELECT * FROM events WHERE status='published' ORDER BY event_date ASC")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="page-heading"><span class="eyebrow">CAMPUS OPPORTUNITIES</span><h1>Discover events</h1><p>Find an event that interests you and apply to be part of the volunteer team.</p></section>
<div class="event-grid">
<?php foreach ($events as $event): ?>
<article class="event-card"><div class="event-date"><strong><?= date('d',strtotime($event['event_date'])) ?></strong><span><?= date('M Y',strtotime($event['event_date'])) ?></span></div><div class="event-content"><span class="pill"><?= e(ucfirst($event['status'])) ?></span><h3><?= e($event['title']) ?></h3><p><?= e(mb_strimwidth($event['description'] ?? '',0,150,'…')) ?></p><div class="event-meta">⌖ <?= e($event['venue']) ?> · <?= (int)$event['volunteer_limit'] ?> places</div><a class="text-link" href="event.php?id=<?= (int)$event['id'] ?>">View details →</a></div></article>
<?php endforeach; ?>
<?php if (!$events): ?><div class="empty-state">No events are available yet.</div><?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
