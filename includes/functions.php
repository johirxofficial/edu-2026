<?php
/**
 * সাধারণ ফাংশন ফাইল
 * সব গুরুত্বপূর্ণ হেলপার ফাংশন এখানে
 */

// সেশন স্টার্ট করুন
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// হ্যাশ পাসওয়ার্ড
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// পাসওয়ার্ড যাচাই করুন
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// সিকিউর র‍্যান্ডম টোকেন জেনারেট করুন
function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

// SQL ইনজেকশন থেকে রক্ষা করুন
function escapeString($conn, $string) {
    return $conn->real_escape_string($string);
}

// ইনপুট স্যানিটাইজ করুন
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// ইমেইল যাচাই করুন
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// ফোন নম্বর যাচাই করুন
function validatePhone($phone) {
    return preg_match('/^(88)?0?1[13-9]\d{8}$/', $phone);
}

// লগ ইন করা ব্যবহারকারী পান
function getLoggedInUser() {
    return $_SESSION['user'] ?? null;
}

// চেক করুন ব্যবহারকারী লগ ইন করেছে কিনা
function isLoggedIn() {
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

// চেক করুন অ্যাডমিন কিনা
function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}

// চেক করুন ইন্সট্রাক্টর কিনা
function isInstructor() {
    return isLoggedIn() && in_array($_SESSION['user']['role'], ['instructor', 'admin']);
}

// রিডিরেক্ট করুন
function redirect($url) {
    header('Location: ' . $url);
    exit();
}

// JSON রেসপন্স পাঠান
function jsonResponse($data, $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

// সাকসেস মেসেজ পাঠান
function successResponse($message, $data = []) {
    return jsonResponse([
        'success' => true,
        'message' => $message,
        'data' => $data
    ], 200);
}

// এরর মেসেজ পাঠান
function errorResponse($message, $errors = [], $statusCode = 400) {
    return jsonResponse([
        'success' => false,
        'message' => $message,
        'errors' => $errors
    ], $statusCode);
}

// লগ অ্যাক্টিভিটি
function logActivity($conn, $action, $entity_type, $entity_id = null, $description = null) {
    $user_id = isLoggedIn() ? $_SESSION['user']['id'] : null;
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    $query = "INSERT INTO edu_activity_log (user_id, action, entity_type, entity_id, description, ip_address, user_agent) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ississs", $user_id, $action, $entity_type, $entity_id, $description, $ip_address, $user_agent);
    return $stmt->execute();
}

// ডাটাবেস কোয়েরি চালান
function executeQuery($conn, $query, $params = [], $types = "") {
    $stmt = $conn->prepare($query);
    if (!empty($params) && !empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt;
}

// একটি সারি আনুন
function getRow($conn, $query, $params = [], $types = "") {
    $stmt = executeQuery($conn, $query, $params, $types);
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// সব সারি আনুন
function getRows($conn, $query, $params = [], $types = "") {
    $stmt = executeQuery($conn, $query, $params, $types);
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

// সেটিংস পান
function getSetting($conn, $key, $default = null) {
    $setting = getRow($conn, "SELECT setting_value FROM edu_settings WHERE setting_key = ?", [$key], "s");
    return $setting ? $setting['setting_value'] : $default;
}

// সেটিংস সেট করুন
function setSetting($conn, $key, $value) {
    $query = "INSERT INTO edu_settings (setting_key, setting_value) VALUES (?, ?) 
              ON DUPLICATE KEY UPDATE setting_value = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $key, $value, $value);
    return $stmt->execute();
}

// তারিখ ফরম্যাট করুন
function formatDate($date, $format = 'd-m-Y H:i') {
    return date($format, strtotime($date));
}

// সময় সাধারণ ভাষায় পান
function getTimeAgo($datetime) {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;

    if ($diff < 60) {
        return 'এখনই';
    } elseif ($diff < 3600) {
        $mins = intval($diff / 60);
        return $mins . ' মিনিট আগে';
    } elseif ($diff < 86400) {
        $hours = intval($diff / 3600);
        return $hours . ' ঘণ্টা আগে';
    } elseif ($diff < 604800) {
        $days = intval($diff / 86400);
        return $days . ' দিন আগে';
    } else {
        return formatDate($datetime);
    }
}

// প্রগতির শতাংশ গণনা করুন
function calculateProgress($conn, $user_id, $course_id) {
    $total = getRow($conn, 
        "SELECT COUNT(*) as count FROM edu_lessons WHERE course_id = ?", 
        [$course_id], "i"
    );
    
    $completed = getRow($conn, 
        "SELECT COUNT(*) as count FROM edu_progress WHERE user_id = ? AND course_id = ?", 
        [$user_id, $course_id], "ii"
    );
    
    if ($total['count'] == 0) return 0;
    return round(($completed['count'] / $total['count']) * 100, 2);
}

// ফাইল আপলোড করুন
function uploadFile($file, $type = 'image', $uploadDir = '../uploads/') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'ফাইল আপলোড ব্যর্থ'];
    }

    $allowed_types = [
        'image' => ['jpg', 'jpeg', 'png', 'gif'],
        'document' => ['pdf', 'doc', 'docx', 'txt'],
        'video' => ['mp4', 'avi', 'mov', 'wmv']
    ];

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($ext, $allowed_types[$type] ?? [])) {
        return ['success' => false, 'message' => 'অবৈধ ফাইল ধরন'];
    }

    if ($file['size'] > 50 * 1024 * 1024) { // 50MB
        return ['success' => false, 'message' => 'ফাইলের আকার খুব বড়'];
    }

    $filename = uniqid() . '.' . $ext;
    $filepath = $uploadDir . $filename;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename, 'path' => $filepath];
    }

    return ['success' => false, 'message' => 'ফাইল সংরক্ষণ ব্যর্থ'];
}

// মেইল পাঠান
function sendEmail($to, $subject, $message, $headers = "") {
    if (empty($headers)) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    }
    return mail($to, $subject, $message, $headers);
}

// এসএমএস পাঠান (Twilio ইন্টিগ্রেশন)
function sendSMS($phone, $message) {
    // SMS গেটওয়ে ইন্টিগ্রেশন এখানে যোগ করুন
    return true;
}

// ক্যাপাসিটি পান
function getCapacity() {
    return 1000; // ম্যাক্স ছাত্র
}

?>
