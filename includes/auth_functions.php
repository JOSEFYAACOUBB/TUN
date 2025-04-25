<?php
// Function to redirect users
function redirect($url) {
    header("Location: $url");
    exit();
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to check if user is admin
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Function to check if user is tourist
function is_tourist() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'tourist';
}

// Function to login admin
function login_admin($nom_utilisateur, $mot_de_passe) {
    global $pdo;
    
    // Requête mise à jour avec les nouveaux noms de colonnes
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE nom_utilisateur = ?");
    $stmt->execute([$nom_utilisateur]);
    $admin = $stmt->fetch();
    
    // Vérification du mot de passe avec le nouveau nom de colonne
    if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['user_role'] = 'admin';
        $_SESSION['nom_utilisateur'] = $admin['nom_utilisateur']; // Mise à jour ici aussi
        return true;
    }
    return false;
}

// Function to login tourist
function login_tourist($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM tourists WHERE username = ?");
    $stmt->execute([$username]);
    $tourist = $stmt->fetch();
    
    if ($tourist && password_verify($password, $tourist['password'])) {
        $_SESSION['user_id'] = $tourist['id'];
        $_SESSION['user_role'] = 'tourist';
        $_SESSION['username'] = $tourist['username'];
        $_SESSION['points'] = $tourist['points'];
        return true;
    }
    return false;
}

// Function to register tourist
function register_tourist($username, $password, $email, $full_name, $phone = null, $country = null) {
    global $pdo;
    
    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT id FROM tourists WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        return false;
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new tourist
    $stmt = $pdo->prepare("INSERT INTO tourists (username, password, email, full_name, phone, country) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$username, $hashed_password, $email, $full_name, $phone, $country]);
}
?>