<?php
/**
 * Database Configuration File
 * সম্পূর্ণ নিরাপদ ডাটাবেস কানেকশন
 */

// এনভায়রনমেন্ট ভেরিয়েবল লোড করুন
if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
    foreach ($env as $key => $value) {
        $_ENV[$key] = $value;
    }
} else {
    // ডিফল্ট সেটিংস
    $_ENV['DB_HOST'] = 'localhost';
    $_ENV['DB_USER'] = 'root';
    $_ENV['DB_PASS'] = '';
    $_ENV['DB_NAME'] = 'eduplatform_2026';
}

// ডাটাবেস কানেকশন
try {
    $conn = new mysqli(
        $_ENV['DB_HOST'] ?? 'localhost',
        $_ENV['DB_USER'] ?? 'root',
        $_ENV['DB_PASS'] ?? '',
        $_ENV['DB_NAME'] ?? 'eduplatform_2026'
    );

    // ইউটিএফ-৮ সেট করুন
    if ($conn->connect_error) {
        die(json_encode(['error' => 'ডাটাবেস সংযোগ ব্যর্থ: ' . $conn->connect_error]));
    }

    // চেঞ্জসেট সেট করুন
    $conn->set_charset("utf8mb4");

    // গ্লোবাল ভেরিয়েবল
    define('DB_PREFIX', 'edu_');

} catch (Exception $e) {
    die('ডাটাবেস এরর: ' . $e->getMessage());
}

?>
