<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/temple_data.php';
require_once __DIR__ . '/../includes/auth.php';

$temples = get_temples();

if (!isset($templeId) || !is_int($templeId) || !isset($temples[$templeId])) {
    http_response_code(404);
    exit('Temple not found');
}

$temple = $temples[$templeId];
$pageTitle = $temple['name'];
$basePath = $basePath ?? '../';

require_once __DIR__ . '/../includes/header.php';

$currentBooking = null;
if (is_logged_in()) {
    $currentBooking = get_user_booking(current_username());
}

$defaultBookingDate = date('Y-m-d');
?>

<div class="page">
    <div class="two-col">
        <section class="panel">
            <h1 style="margin:0 0 8px;"><?= htmlspecialchars($temple['name']) ?></h1>
            <div class="subtle"><?= htmlspecialchars($temple['city']) ?></div>
            <div style="height:220px; margin-top:14px; border-radius: 18px; overflow:hidden; border: 1px solid rgba(255,255,255,0.12); background: rgba(255,255,255,0.03);">
                <img src="<?= $basePath ?><?= $temple['image'] ?>" alt="<?= htmlspecialchars($temple['name']) ?>" style="width:100%; height:100%; object-fit:cover; display:block;">
            </div>

            <div class="section-title">Temple Information</div>
            <div class="subtle"><?= htmlspecialchars($temple['about']) ?></div>

            <div class="section-title">Pooja Timings</div>
            <div class="list">
                <?php foreach ($temple['pooja_timings'] as $timing): ?>
                    <div class="list-item">
                        <strong><?= htmlspecialchars($timing['label']) ?></strong>
                        <span class="subtle"><?= htmlspecialchars($timing['time']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="section-title">Seva List</div>
            <div class="list">
                <?php foreach ($temple['sevas'] as $seva): ?>
                    <div class="list-item"><?= htmlspecialchars($seva) ?></div>
                <?php endforeach; ?>
            </div>
        </section>

        <aside class="panel">
            <div class="section-title" style="margin-top:0;">Hotels Nearby</div>
            <div class="list">
                <?php foreach ($temple['hotels'] as $hotel): ?>
                    <div class="list-item">
                        <strong><?= htmlspecialchars($hotel['name']) ?></strong>
                        <span class="subtle">Distance: <?= htmlspecialchars($hotel['distance']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="section-title">Rooms Nearby</div>
            <?php foreach ($temple['rooms'] as $room): ?>
                <div class="list-item" style="margin-bottom: 12px;">
                    <div class="room-row">
                        <div class="room-meta">
                            <strong><?= htmlspecialchars($room['name']) ?></strong>
                            <div class="subtle"><?= htmlspecialchars($room['details']) ?></div>
                            <div class="price"><?= htmlspecialchars($room['price']) ?></div>
                        </div>
                        <form class="room-form" method="post" action="<?= $basePath ?>book_room.php">
                            <input type="hidden" name="room_booked" value="<?= htmlspecialchars($temple['name'] . ' - ' . $room['name']) ?>">
                            <input type="hidden" name="return_to" value="<?= htmlspecialchars($returnTo ?? ('temples/temple' . $templeId . '.php')) ?>">
                            <div style="margin:10px 0 10px;">
                                <div class="subtle" style="margin-bottom:6px;">Booking Date</div>
                                <input type="date" name="booking_date" required value="<?= htmlspecialchars($defaultBookingDate) ?>" style="width:100%;">
                            </div>
                            <button class="btn btn-primary" type="submit">Book Room</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if ($currentBooking): ?>
                <div class="section-title">Your Booking</div>
                <div class="list">
                    <div class="list-item">
                        <strong>Booked</strong>
                        <span class="subtle"><?= htmlspecialchars($currentBooking) ?></span>
                    </div>
                </div>
            <?php else: ?>
                <div class="section-title">Your Booking</div>
                <div class="subtle">Book any room to see it here.</div>
            <?php endif; ?>
        </aside>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

