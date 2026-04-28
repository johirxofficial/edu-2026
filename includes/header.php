<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../includes/functions.php');

$site_name = getSetting($conn, 'site_name', 'EduPlatform BD 2026');
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HSC 2026 পরীক্ষার্থীদের জন্য সম্পূর্ণ অনলাইন শিক্ষা প্ল্যাটফর্ম">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . $site_name : $site_name; ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo '/edu-2026/assets/css/style.css'; ?>">
    <link rel="stylesheet" href="<?php echo '/edu-2026/assets/css/responsive.css'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Tiro+Bangla&display=swap" rel="stylesheet">
</head>
<body>
