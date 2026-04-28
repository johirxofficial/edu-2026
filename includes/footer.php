    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <h4>📚 <?php echo getSetting($conn, 'site_name', 'EduPlatform BD 2026'); ?></h4>
                    <p>HSC ২০২৬ পরীক্ষার্থীদের জন্য বাংলাদেশের সেরা অনলাইন স্টাডি প্ল্যাটফর্ম।</p>
                </div>
                <div class="footer-col">
                    <h4>দ্রুত লিংক</h4>
                    <ul>
                        <li><a href="/edu-2026/">হোম</a></li>
                        <li><a href="/edu-2026/pages/login.php">লগইন</a></li>
                        <li><a href="/edu-2026/pages/register.php">রেজিস্ট্রেশন</a></li>
                        <li><a href="/edu-2026/#courses">কোর্স</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>যোগাযোগ</h4>
                    <p>
                        <i class="fas fa-envelope"></i> <?php echo getSetting($conn, 'site_email', 'info@eduplatform.com.bd'); ?><br>
                        <i class="fas fa-phone"></i> <?php echo getSetting($conn, 'site_phone', '01700-000000'); ?>
                    </p>
                </div>
                <div class="footer-col">
                    <h4>সোশ্যাল মিডিয়া</h4>
                    <div class="social-links">
                        <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; ২০২৬ <?php echo getSetting($conn, 'site_name', 'EduPlatform BD 2026'); ?> — সকল অধিকার সংরক্ষিত</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="<?php echo '/edu-2026/assets/js/main.js'; ?>"></script>
</body>
</html>
