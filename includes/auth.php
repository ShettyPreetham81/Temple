<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function is_logged_in(): bool
{
    return isset($_SESSION['username']) && is_string($_SESSION['username']) && $_SESSION['username'] !== '';
}

function is_admin_logged_in(): bool
{
    return isset($_SESSION['admin_username']) && is_string($_SESSION['admin_username']) && $_SESSION['admin_username'] !== '';
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function require_admin_login(): void
{
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function current_username(): string
{
    return (string)$_SESSION['username'];
}

function current_admin_username(): string
{
    return (string)$_SESSION['admin_username'];
}

function get_user_booking(string $username): ?string
{
    // Try to include booking date (newer schemas). Fallback for older schemas.
    try {
        $sql = 'SELECT room_booked, booking_date FROM room_bookings WHERE username = ?';
        $stmt = db()->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($roomBooked, $bookingDate);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }

        $roomBookedStr = (string)$roomBooked;
        $bookingDateStr = $bookingDate ? (string)$bookingDate : '';
        return $bookingDateStr !== '' ? ($roomBookedStr . ' on ' . $bookingDateStr) : $roomBookedStr;
    } catch (Throwable $e) {
        $sql = 'SELECT room_booked FROM room_bookings WHERE username = ?';
        $stmt = db()->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($roomBooked);
        $row = $stmt->fetch();
        return $row ? (string)$roomBooked : null;
    }
}

function get_all_bookings(): array
{
    // Try to include booking_date (newer schemas). Fallback for older schemas.
    try {
        $sql = 'SELECT u.username, u.email, rb.room_booked, rb.booking_date
                FROM room_bookings rb
                INNER JOIN users u ON u.username = rb.username
                ORDER BY u.username ASC';
        $result = db()->query($sql);
        if (!$result instanceof mysqli_result) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (Throwable $e) {
        $sql = 'SELECT u.username, u.email, rb.room_booked, NULL AS booking_date
                FROM room_bookings rb
                INNER JOIN users u ON u.username = rb.username
                ORDER BY u.username ASC';
        $result = db()->query($sql);
        if (!$result instanceof mysqli_result) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

function flash_set(string $key, string $message): void
{
    $_SESSION[$key] = $message;
}

function flash_get(string $key): ?string
{
    if (!isset($_SESSION[$key])) {
        return null;
    }
    $msg = (string)$_SESSION[$key];
    unset($_SESSION[$key]);
    return $msg;
}

