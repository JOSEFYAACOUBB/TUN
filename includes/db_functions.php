<?php
// Function to get all eco-lodges
function get_eco_lodges($limit = null) {
    global $pdo;
    $sql = "SELECT id, name, location, description, price_per_night, capacity, sustainability_score, image_url FROM eco_lodges";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_activities($limit = null) {
    global $pdo;
    $sql = "SELECT id, name, location, description, price, duration, points_reward, image_url FROM activities";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get lodge by ID
function get_lodge_by_id($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM eco_lodges WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}


// Function to get activity by ID
function get_activity_by_id($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM activities WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Function to get tourist bookings
function get_tourist_bookings($tourist_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT b.*, 
               l.name as lodge_name, 
               a.name as activity_name 
        FROM bookings b
        LEFT JOIN eco_lodges l ON b.lodge_id = l.id
        LEFT JOIN activities a ON b.activity_id = a.id
        WHERE b.tourist_id = ?
        ORDER BY b.booking_date DESC
    ");
    $stmt->execute([$tourist_id]);
    return $stmt->fetchAll();
}

// Function to create a booking
function create_booking($tourist_id, $lodge_id, $activity_id, $booking_date) {
    global $pdo;
    
    // Calculate points based on what's being booked
    $points_earned = 0;
    if ($lodge_id) {
        $points_earned += 50; // Base points for lodge booking
    }
    if ($activity_id) {
        $activity = get_activity_by_id($activity_id);
        $points_earned += $activity['points_reward'];
    }
    
    // Create booking
    $stmt = $pdo->prepare("INSERT INTO bookings (tourist_id, lodge_id, activity_id, booking_date, points_earned) VALUES (?, ?, ?, ?, ?)");
    $booking_success = $stmt->execute([$tourist_id, $lodge_id, $activity_id, $booking_date, $points_earned]);
    
    if ($booking_success && $points_earned > 0) {
        // Update tourist points
        $pdo->prepare("UPDATE tourists SET points = points + ? WHERE id = ?")->execute([$points_earned, $tourist_id]);
        
        // Record points transaction
        $booking_id = $pdo->lastInsertId();
        $description = $lodge_id ? "Lodge booking" : "Activity booking";
        $pdo->prepare("INSERT INTO points_transactions (tourist_id, points, transaction_type, description, reference_id) VALUES (?, ?, 'earned', ?, ?)")
            ->execute([$tourist_id, $points_earned, $description, $booking_id]);
            
        // Update session points
        $_SESSION['points'] += $points_earned;
    }
    
    return $booking_success;
}

// Function to get tourist points transactions
function get_points_transactions($tourist_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM points_transactions WHERE tourist_id = ? ORDER BY created_at DESC");
    $stmt->execute([$tourist_id]);
    return $stmt->fetchAll();
}

// Function to get all bookings (admin)
function get_all_bookings() {
    global $pdo;
    
    $stmt = $pdo->query("
        SELECT b.*, 
               t.username as tourist_username,
               l.name as lodge_name, 
               a.name as activity_name 
        FROM bookings b
        LEFT JOIN tourists t ON b.tourist_id = t.id
        LEFT JOIN eco_lodges l ON b.lodge_id = l.id
        LEFT JOIN activities a ON b.activity_id = a.id
        ORDER BY b.created_at DESC
    ");
    return $stmt->fetchAll();
}

// Function to get all tourists (admin)
function get_all_tourists() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, username, email, created_at AS registration_date, points FROM tourists ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>