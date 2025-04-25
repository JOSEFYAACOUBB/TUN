<?php
require_once __DIR__ . '/../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    $_SESSION['error_message'] = 'Accès non autorisé';
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    $_SESSION['error_message'] = 'ID de touriste invalide';
    header('Location: tourists.php');
    exit;
}

$tourist_id = (int)$_GET['id'];

try {
    // Vérifier si le touriste existe
    $stmt = $pdo->prepare("SELECT id FROM tourists WHERE id = ? LIMIT 1");
    if (!$stmt->execute([$tourist_id])) {
        throw new PDOException('Échec de la vérification du touriste');
    }
    
    if ($stmt->rowCount() === 0) {
        $_SESSION['error_message'] = 'Touriste non trouvé';
        header('Location: tourists.php');
        exit;
    }

    // Vérifier les réservations existantes
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE tourist_id = ?");
    if (!$stmt->execute([$tourist_id])) {
        throw new PDOException('Échec de la vérification des réservations');
    }
    
    $booking_count = $stmt->fetchColumn();
    if ($booking_count === false) {
        throw new PDOException('Échec de la récupération du nombre de réservations');
    }

    if ($booking_count > 0) {
        $_SESSION['error_message'] = 'Impossible de supprimer un touriste avec des réservations';
        header('Location: tourists.php');
        exit;
    }

    // Supprimer le touriste
    $stmt = $pdo->prepare("DELETE FROM tourists WHERE id = ? LIMIT 1");
    if (!$stmt->execute([$tourist_id])) {
        throw new PDOException('Échec de la suppression du touriste');
    }

    if ($stmt->rowCount() === 1) {
        $_SESSION['success_message'] = 'Touriste supprimé avec succès';
    } else {
        $_SESSION['error_message'] = 'Aucun touriste supprimé';
    }

} catch (PDOException $e) {
    error_log('Erreur DB dans delete_tourist.php: ' . $e->getMessage());
    $_SESSION['error_message'] = 'Erreur de base de données';
} catch (Exception $e) {
    error_log('Erreur dans delete_tourist.php: ' . $e->getMessage());
    $_SESSION['error_message'] = 'Erreur système';
}

header('Location: tourists.php');
exit;
?>