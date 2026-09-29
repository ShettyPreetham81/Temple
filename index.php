<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/temple_data.php';

$temples = get_temples();
$pageTitle = 'Temples';
$basePath = '';

require_once __DIR__ . '/includes/header.php';
?>

<div class="page">
    <h1 style="margin:10px 0 6px;">Explore Temples</h1>
    <div class="subtle">Click any temple to view pooja timings, seva, nearby hotels, and rooms.</div>

    <div class="grid">
        <?php foreach ($temples as $temple): ?>
            <div class="card">
                <div class="card-media">
                    <img src="<?= $basePath ?><?= $temple['image'] ?>" alt="<?= htmlspecialchars($temple['name']) ?>">
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?= htmlspecialchars($temple['name']) ?></h3>
                    <div class="card-sub"><?= htmlspecialchars($temple['city']) ?></div>
                    <div class="card-actions">
                        <a class="btn btn-primary" href="<?= $basePath ?>temples/<?= 'temple' . $temple['id'] . '.php' ?>">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

