<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('bookings.php');
}

$booking_id = (int)$_GET['id'];

// Update booking status to confirmed
$stmt = $pdo->prepare("UPDATE bookings SET status = 'confirmed' WHERE id = ?");
if ($stmt->execute([$booking_id])) {
    $_SESSION['success_message'] = 'Booking confirmed successfully!';
} else {
    $_SESSION['error_message'] = 'Failed to confirm booking. Please try again.';
}

redirect('bookings.php');
?>