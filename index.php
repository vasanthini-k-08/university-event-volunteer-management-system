<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Home';
$stmt = $pdo->query("SELECT id, title, description, event_date, venue, volunteer_limit FROM events WHERE status='published' AND event_date >= CURDATE() ORDER BY event_date ASC LIMIT 3");
$events = $stmt->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-copy">
    <span class="eyebrow">INSTITUTE OF TECHNOLOGY · UNIVERSITY OF MORATUWA</span>
    <h1>Make every campus event <em>better together.</em></h1>
    <p>Discover university events, volunteer your skills, take on meaningful tasks and be part of the ITUM community.</p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="events.php">Explore Events</a>
      <a class="btn btn-light" href="register.php">Become a Volunteer</a>
    </div>
  </div>
  <div class="hero-card">
    <div class="hero-icon">✦</div>
    <h3>Your time. Your talent. Our campus.</h3>
    <p>One place to discover events, coordinate volunteers and celebrate teamwork.</p>
    <div class="mini-stats"><div><strong>01</strong><span>Discover</span></div><div><strong>02</strong><span>Volunteer</span></div><div><strong>03</strong><span>Contribute</span></div></div>
  </div>
</section>
<section class="section-head"><div><span class="eyebrow">WHAT'S HAPPENING</span><h2>Upcoming events</h2></div><a class="text-link" href="events.php">View all events →</a></section>
<div class="event-grid">
<?php if (!$events): ?>
  <div class="empty-state">No published events yet. Please check again soon.</div>
<?php else: foreach ($events as $event): ?>
  <article class="event-card">
    <div class="event-date"><strong><?= date('d', strtotime($event['event_date'])) ?></strong><span><?= date('M Y', strtotime($event['event_date'])) ?></span></div>
    <div class="event-content"><h3><?= e($event['title']) ?></h3><p><?= e(mb_strimwidth($event['description'] ?? '', 0, 120, '…')) ?></p><div class="event-meta">⌖ <?= e($event['venue']) ?> · <?= (int)$event['volunteer_limit'] ?> volunteer places</div><a class="text-link" href="event.php?id=<?= (int)$event['id'] ?>">View details →</a></div>
  </article>
<?php endforeach; endif; ?>
</div>
<section class="feature-strip"><div><span class="eyebrow">A SIMPLE PROCESS</span><h2>From interest to impact.</h2></div><div class="feature">01 <strong>Find an event</strong><span>Browse opportunities on campus.</span></div><div class="feature">02 <strong>Apply to volunteer</strong><span>Share your interest and availability.</span></div><div class="feature">03 <strong>Make a difference</strong><span>Complete tasks and track participation.</span></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
