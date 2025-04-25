<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('activities.php');
}

$activity_id = (int)$_GET['id'];

// Check if activity exists
$activity = get_activity_by_id($activity_id);
if (!$activity) {
    redirect('activities.php');
}

// Check if there are any bookings for this activity
$stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE activity_id = ?");
$stmt->execute([$activity_id]);
$booking_count = $stmt->fetchColumn();

if ($booking_count > 0) {
    $_SESSION['error_message'] = 'Cannot delete activity with existing bookings.';
    redirect('activities.php');
}

// Delete the activity
$stmt = $pdo->prepare("DELETE FROM activities WHERE id = ?");
if ($stmt->execute([$activity_id])) {
    $_SESSION['success_message'] = 'Activity deleted successfully!';
} else {
    $_SESSION['error_message'] = 'Failed to delete activity. Please try again.';
}

redirect('activities.php');
?>
<?php include 'admin_footer.php'; ?>
