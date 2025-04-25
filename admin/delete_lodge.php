<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('lodges.php');
}

$lodge_id = (int)$_GET['id'];

// Check if lodge exists
$lodge = get_lodge_by_id($lodge_id);
if (!$lodge) {
    redirect('lodges.php');
}

// Check if there are any bookings for this lodge
$stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE lodge_id = ?");
$stmt->execute([$lodge_id]);
$booking_count = $stmt->fetchColumn();

if ($booking_count > 0) {
    $_SESSION['error_message'] = 'Cannot delete lodge with existing bookings.';
    redirect('lodges.php');
}

// Delete the lodge
$stmt = $pdo->prepare("DELETE FROM eco_lodges WHERE id = ?");
if ($stmt->execute([$lodge_id])) {
    $_SESSION['success_message'] = 'Eco-lodge deleted successfully!';
} else {
    $_SESSION['error_message'] = 'Failed to delete eco-lodge. Please try again.';
}

redirect('lodges.php');
?>