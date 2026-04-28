<?php
$page_title = 'হোম';
require_once(__DIR__ . '/includes/header.php');
?>

<!-- Navbar -->
<nav class="navbar">
    <div class="container">
        <div class="logo">
            <i class="fas fa-book"></i>
            <span>EduPlatform BD</span>
        </div>
        <button class="navbar-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="nav-menu">
            <a href="#courses">কোর্সসমূহ</a>
            <a href="#features">বৈশিষ্ট্য</a>
            <a href="#testimonials">মতামত</a>
            <a href="#faq">প্রশ্ন</a>
        </div>
        <div class="navbar-auth">
            <?php if (isLoggedIn()): ?>
                <div class="user-menu">
                    <span class="user-greeting">স্বাগতম, <?php echo sanitize($_SESSION['user']['full_name']); ?></span>
                    <a href="/edu-2026/user/dashboard.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-th-large"></i> ড্যাশবোর্ড
                    </a>
                    <a href="/edu-2026/user/logout.php" class="btn btn-ghost btn-sm">
                        <i class="fas fa-sign-out-alt"></i> লগআউট
                    </a>
                </div>
            <?php else: ?>
                <button class="btn btn-ghost" data-modal="login">
                    <i class="fas fa-sign-in-alt"></i> লগইন
                </button>
                <button class="btn btn-primary" data-modal="register">
                    <i class="fas fa-user-plus"></i> রেজিস্টার
                </button>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>HSC 2026 এর জন্য সম্পূর্ণ স্টাডি প্ল্যাটফর্ম</h1>
            <p>বিশেষজ্ঞ শিক্ষকদের সাথে পড়াশোনা করুন, সঠিক সময়ে পরীক্ষা দিন এবং আপনার লক্ষ্য অর্জন করুন।</p>
            <div class="hero-buttons">
                <?php if (!isLoggedIn()): ?>
                    <button class="btn btn-primary btn-lg glow" data-modal="register">
                        <i class="fas fa-rocket"></i> এখনই শুরু করুন
                    </button>
                    <button class="btn btn-ghost btn-lg" data-modal="login">
                        <i class="fas fa-play"></i> ডেমো দেখুন
                    </button>
                <?php else: ?>
                    <a href="/edu-2026/user/courses.php" class="btn btn-primary btn-lg glow">
                        <i class="fas fa-book"></i> আমার কোর্সগুলি
                    </a>
                    <a href="/edu-2026/user/dashboard.php" class="btn btn-ghost btn-lg">
                        <i class="fas fa-chart-line"></i> আমার অগ্রগতি
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="hero-image">📚</div>
    </div>
</section>

<!-- Features Section -->
<section id="features" style="background: var(--dark-light); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
    <div class="container">
        <div class="section-title">
            <div class="section-tag">✨ কোর্সে কী আছে</div>
            <h2>সব কিছু একটাই প্ল্যাটফর্মে</h2>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-calendar-alt"></i>
                <h3>৭ দিনের রুটিন</h3>
                <p>প্রতিটি বিষয়ের জন্য নির্দিষ্ট সময়সূচী</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-question-circle"></i>
                <h3>বিগত সালের প্রশ্ন</h3>
                <p>২০১৮–২০২৪ এর সাপ্তাহিক কুইজ</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-mobile-alt"></i>
                <h3>আসক্তি কমানো</h3>
                <p>ফোন আসক্তি দূর করার প্রমাণিত কৌশল</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-trophy"></i>
                <h3>লিডারবোর্ড</h3>
                <p>প্রতিযোগিতামূলক পয়েন্ট সিস্টেম</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-chart-line"></i>
                <h3>প্রগতি ট্র্যাকিং</h3>
                <p>আপনার শেখার অগ্রগতি দেখুন</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-comments"></i>
                <h3>কমিউনিটি</h3>
                <p>হাজারো ছাত্রছাত্রীর সাথে যুক্ত হন</p>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section id="courses">
    <div class="container">
        <div class="section-title">
            <div class="section-tag">📚 আমাদের কোর্সসমূহ</div>
            <h2>তোমার লক্ষ্য অনুযায়ী কোর্স বেছে নাও</h2>
        </div>
        <div class="courses-grid">
            <?php
            $courses = getRows($conn, "SELECT * FROM edu_courses WHERE status = 'active' LIMIT 4");
            foreach ($courses as $course):
            ?>
                <div class="course-card">
                    <div class="course-image">📖</div>
                    <div class="course-body">
                        <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                        <p class="course-desc"><?php echo htmlspecialchars(substr($course['description'], 0, 100)); ?>...</p>
                        <div class="course-footer">
                            <div class="course-price">৳<?php echo $course['price']; ?></div>
                            <?php if (isLoggedIn()): ?>
                                <button class="btn btn-primary btn-sm" onclick="enrollCourse(<?php echo $course['id']; ?>)">
                                    এনরোল করুন
                                </button>
                            <?php else: ?>
                                <button class="btn btn-primary btn-sm" data-modal="login">
                                    এনরোল করুন
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" style="background: var(--dark-light); border-top: 1px solid var(--border);">
    <div class="container">
        <div class="section-title">
            <div class="section-tag">💬 শিক্ষার্থীদের মতামত</div>
            <h2>তারা কী বলছে</h2>
        </div>
        <div class="testimonials-grid">
            <div class="card">
                <p style="margin-bottom: var(--spacing-lg);">
                    "EduPlatform-এর সাথে আমার পড়াশোনা সম্পূর্ণ বদলে গেছে। প্রগতি ট্র্যাকিং খুবই দারুণ!" - ⭐⭐⭐⭐⭐
                </p>
                <p style="margin: 0; font-weight: 600;">ফাহিম রহমান, HSC 2026</p>
            </div>
            <div class="card">
                <p style="margin-bottom: var(--spacing-lg);">
                    "লিডারবোর্ডে আসার চেষ্টা করতে গিয়ে আমার মোটিভেশন অনেক বেড়ে গেছে।" - ⭐⭐⭐⭐⭐
                </p>
                <p style="margin: 0; font-weight: 600;">নাদিয়া আক্তার, HSC 2026</p>
            </div>
            <div class="card">
                <p style="margin-bottom: var(--spacing-lg);">
                    "গণিত এবং পদার্থের জটিল বিষয়গুলো এত সহজ কখনো মনে হয়নি!" - ⭐⭐⭐⭐⭐
                </p>
                <p style="margin: 0; font-weight: 600;">আরিফ হোসেইন, HSC 2026</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 215, 0, 0.06)); border-top: 1px solid rgba(255, 107, 53, 0.2); border-bottom: 1px solid rgba(255, 107, 53, 0.2); text-align: center; padding: var(--spacing-2xl) 0;">
    <div class="container">
        <div class="section-tag">⏳ সীমিত সময়ের অফার</div>
        <h2 style="margin: var(--spacing-md) 0;">এখনই যোগ দাও — মাত্র ৳৪৯!</h2>
        <p style="margin-bottom: var(--spacing-lg);">অফার শেষ হওয়ার আগেই সুযোগ নাও</p>
        <?php if (!isLoggedIn()): ?>
            <button class="btn btn-primary btn-lg glow" data-modal="register">
                <i class="fas fa-check"></i> এখনই রেজিস্টার করো
            </button>
        <?php else: ?>
            <a href="/edu-2026/user/courses.php" class="btn btn-primary btn-lg glow">
                <i class="fas fa-check"></i> কোর্স দেখুন
            </a>
        <?php endif; ?>
        <p style="margin-top: var(--spacing-md); color: var(--text-muted); font-size: 0.9rem;">
            bKash / Nagad / Rocket • ৩ দিনের মানি-ব্যাক গ্যারান্টি
        </p>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq">
    <div class="container">
        <div class="section-title">
            <div class="section-tag">❓ সাধারণ প্রশ্নাবলী</div>
            <h2>যা জানতে চাও</h2>
        </div>
        <div style="max-width: 700px; margin: 0 auto;">
            <div class="card" style="margin-bottom: var(--spacing-lg);">
                <h3 style="margin-bottom: var(--spacing-md);">📝 কোর্সে কীভাবে এনরোল করব?</h3>
                <p>রেজিস্টার করুন, লগইন করুন এবং কোর্সে এনরোল করুন। পেমেন্ট সম্পূর্ণ করে অ্যাক্সেস পান।</p>
            </div>
            <div class="card" style="margin-bottom: var(--spacing-lg);">
                <h3 style="margin-bottom: var(--spacing-md);">💰 কোর্সের খরচ কত?</h3>
                <p>প্রতিটি কোর্স ৪৯ টাকা থেকে শুরু। বিশেষ অফার পেতে এখনই এনরোল করুন।</p>
            </div>
            <div class="card" style="margin-bottom: var(--spacing-lg);">
                <h3 style="margin-bottom: var(--spacing-md);">📱 মোবাইলে কোর্স ব্যবহার করা যাবে?</h3>
                <p>হ্যাঁ! সাইটটি সম্পূর্ণ মোবাইল ফ্রেন্ডলি। যেকোনো ডিভাইস থেকে ব্যবহার করতে পারবেন।</p>
            </div>
            <div class="card">
                <h3 style="margin-bottom: var(--spacing-md);">🔄 সন্তুষ্ট না হলে রিফান্ড পাবো?</h3>
                <p>হ্যাঁ! এনরোলের ৩ দিনের মধ্যে সম্পূর্ণ অর্থ ফেরত দেওয়া হবে।</p>
            </div>
        </div>
    </div>
</section>

<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('loginModal')">
            <i class="fas fa-times"></i>
        </button>
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <div style="font-size: 3rem; margin-bottom: var(--spacing-md);">🔐</div>
            <h2>লগইন করুন</h2>
            <p style="color: var(--text-light); margin-top: var(--spacing-sm);">আপনার অ্যাকাউন্টে প্রবেশ করুন</p>
        </div>
        <form action="/edu-2026/api/auth.php?action=login" method="POST">
            <div class="form-group">
                <label class="form-label">ইমেইল / ফোন</label>
                <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
            </div>
            <div class="form-group">
                <label class="form-label">পাসওয়ার্ড</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-sign-in-alt"></i> লগইন করুন
            </button>
            <div style="text-align: center; margin-top: var(--spacing-md); font-size: 0.9rem; color: var(--text-light);">
                অ্যাকাউন্ট নেই? 
                <button type="button" onclick="closeModal('loginModal'); openModal('regModal');" style="background: none; border: none; color: var(--primary); cursor: pointer; font-weight: 600;">
                    রেজিস্টার করুন
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Register Modal -->
<div id="regModal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('regModal')">
            <i class="fas fa-times"></i>
        </button>
        <div style="text-align: center; margin-bottom: var(--spacing-lg);">
            <div style="font-size: 3rem; margin-bottom: var(--spacing-md);">🎓</div>
            <h2>রেজিস্টার করুন</h2>
            <p style="color: var(--text-light); margin-top: var(--spacing-sm);">নতুন অ্যাকাউন্ট তৈরি করুন</p>
        </div>
        <form action="/edu-2026/api/auth.php?action=register" method="POST">
            <div class="form-group">
                <label class="form-label">পূর্ণ নাম</label>
                <input type="text" name="full_name" class="form-control" placeholder="আপনার নাম" required>
            </div>
            <div class="form-group">
                <label class="form-label">ইমেইল</label>
                <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
            </div>
            <div class="form-group">
                <label class="form-label">ফোন নম্বর</label>
                <input type="tel" name="phone" class="form-control" placeholder="01700-000000" required>
            </div>
            <div class="form-group">
                <label class="form-label">পাসওয়ার্ড</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="form-group">
                <label class="form-label">বিভাগ</label>
                <select name="division" class="form-control" required>
                    <option value="">-- নির্বাচন করুন --</option>
                    <option value="science">বিজ্ঞান</option>
                    <option value="commerce">বাণিজ্য</option>
                    <option value="humanities">মানবিক</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-user-plus"></i> রেজিস্টার করুন →
            </button>
            <div style="text-align: center; margin-top: var(--spacing-md); font-size: 0.9rem; color: var(--text-light);">
                অ্যাকাউন্ট আছে? 
                <button type="button" onclick="closeModal('regModal'); openModal('loginModal');" style="background: none; border: none; color: var(--primary); cursor: pointer; font-weight: 600;">
                    লগইন করুন
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function enrollCourse(courseId) {
        if (confirm('এই কোর্সে এনরোল করতে চান?')) {
            apiCall('/edu-2026/api/courses.php?action=enroll', 'POST', { course_id: courseId })
                .then(data => {
                    if (data.success) {
                        showNotification('সফলভাবে এনরোল হয়েছেন!', 'success');
                        setTimeout(() => {
                            window.location.href = '/edu-2026/user/dashboard.php';
                        }, 1500);
                    } else {
                        showNotification('এনরোল ব্যর্থ: ' + data.message, 'danger');
                    }
                });
        }
    }
</script>

<?php require_once(__DIR__ . '/includes/footer.php'); ?>
