<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('bookings.php');
}

$booking_id = (int)$_GET['id'];

// Get booking to check points earned
$stmt = $pdo->prepare("SELECT tourist_id, points_earned FROM bookings WHERE id = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if ($booking) {
    // Remove points from tourist if booking had earned points
    if ($booking['points_earned'] > 0) {
        $pdo->prepare("UPDATE tourists SET points = points - ? WHERE id = ?")
            ->execute([$booking['points_earned'], $booking['tourist_id']]);
    }
}

// Delete the booking
$stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
if ($stmt->execute([$booking_id])) {
    $_SESSION['success_message'] = 'Booking deleted successfully!';
} else {
    $_SESSION['error_message'] = 'Failed to delete booking. Please try again.';
}

redirect('bookings.php');
?>