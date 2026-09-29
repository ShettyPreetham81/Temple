<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

require_admin_login();

$bookings = get_all_bookings();
$pageTitle = 'Admin Home';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page">
    <h1 style="margin:10px 0 6px;">Admin Home</h1>
    <div class="subtle">Users who booked rooms in various temples.</div>

    <div class="panel" style="margin-top:16px;">
        <?php if (count($bookings) === 0): ?>
            <div class="subtle">No room bookings found yet.</div>
        <?php else: ?>
            <div style="overflow:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.15);">Username</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.15);">Email</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.15);">Temple / Room</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,0.15);">Booking Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.08);"><?= htmlspecialchars((string)$booking['username']) ?></td>
                            <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.08);"><?= htmlspecialchars((string)$booking['email']) ?></td>
                            <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.08);"><?= htmlspecialchars((string)$booking['room_booked']) ?></td>
                            <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.08);"><?= htmlspecialchars((string)($booking['booking_date'] ?? 'N/A')) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
