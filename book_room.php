<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$roomBooked = trim((string)($_POST['room_booked'] ?? ''));
$bookingDate = trim((string)($_POST['booking_date'] ?? ''));
$returnTo = (string)($_POST['return_to'] ?? 'index.php');

// Prevent open redirect by only allowing our known internal paths.
if (!in_array($returnTo, ['index.php', 'temples/temple1.php', 'temples/temple2.php', 'temples/temple3.php', 'temples/temple4.php', 'temples/temple5.php', 'temples/temple6.php', 'temples/temple7.php', 'temples/temple8.php'], true)) {
    $returnTo = 'index.php';
}

if ($roomBooked === '') {
    flash_set('error', 'Please select a room to book.');
    header('Location: ' . $returnTo);
    exit;
}

if ($bookingDate === '') {
    flash_set('error', 'Please select a booking date.');
    header('Location: ' . $returnTo);
    exit;
}

$username = current_username();

try {
    // Prefer storing booking date if the column exists.
    $sql = 'INSERT INTO room_bookings (username, room_booked, booking_date)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE
                room_booked = VALUES(room_booked),
                booking_date = VALUES(booking_date)';
    $stmt = db()->prepare($sql);
    $stmt->bind_param('sss', $username, $roomBooked, $bookingDate);
    $stmt->execute();

    flash_set('success', 'Room booked successfully: ' . $roomBooked . ' on ' . $bookingDate);
} catch (Throwable $e) {
    // Fallback for older table schemas that don't have `booking_date`.
    try {
        $sql = 'INSERT INTO room_bookings (username, room_booked) VALUES (?, ?)
                ON DUPLICATE KEY UPDATE room_booked = VALUES(room_booked)';
        $stmt = db()->prepare($sql);
        $stmt->bind_param('ss', $username, $roomBooked);
        $stmt->execute();

            flash_set('success', 'Room booked successfully: ' . $roomBooked . ' on ' . $bookingDate);
    } catch (Throwable $e2) {
        flash_set('error', 'Booking failed. Please try again.');
    }
}

header('Location: ' . $returnTo);
exit;

