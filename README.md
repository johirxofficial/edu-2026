# EduPlatform BD 2026 - সম্পূর্ণ শিক্ষা প্ল্যাটফর্ম

## 🎓 প্রজেক্ট বর্ণনা
এটি একটি সম্পূর্ণ পেশাদার শিক্ষা প্ল্যাটফর্ম যেখানে:
- **ছাত্রছাত্রীরা**: কোর্সে এনরোল করতে, ক্লাস নিতে, প্রগতি ট্র্যাক করতে পারে
- **প্রশাসকরা**: সব ডেটা পরিচালনা, ব্যবহারকারী পরিচালনা, সাইট সেটিংস করতে পারে

## 📁 প্রজেক্ট স্ট্রাকচার
```
edu-2026/
├── index.php              # মেইন হোমপেজ
├── config/
│   └── database.php       # ডাটাবেস কানেকশন
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── responsive.css
│   ├── js/
│   │   ├── main.js
│   │   └── dashboard.js
│   └── images/
├── pages/
│   ├── login.php
│   ├── register.php
│   ├── forgot-password.php
│   └── verify-email.php
├── user/
│   ├── dashboard.php
│   ├── courses.php
│   ├── progress.php
│   ├── profile.php
│   ├── settings.php
│   └── logout.php
├── admin/
│   ├── index.php          # অ্যাডমিন ড্যাশবোর্ড
│   ├── users.php          # ব্যবহারকারী পরিচালনা
│   ├── courses.php        # কোর্স পরিচালনা
│   ├── enrollments.php    # এনরোলমেন্ট পরিচালনা
│   ├── reports.php        # রিপোর্ট ও বিশ্লেষণ
│   ├── settings.php       # সাইট সেটিংস
│   └── logout.php
├── api/
│   ├── auth.php           # লগইন/রেজিস্ট্রেশন API
│   ├── courses.php        # কোর্স API
│   ├── users.php          # ব্যবহারকারী API
│   └── admin.php          # অ্যাডমিন API
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── sidebar.php
│   └── functions.php      # সাধারণ ফাংশন
├── uploads/               # ফাইল আপলোড ডিরেক্টরি
├── .env.example           # এনভায়রনমেন্ট ভেরিয়েবল
└── sql/
    └── database.sql       # ডাটাবেস স্ট্রাকচার
```

## 🚀 সেটআপ নির্দেশনা

### প্রয়োজনীয়তা
- PHP 7.4+
- MySQL 5.7+
- Apache Server

### ইনস্টলেশন
1. রেপোজিটরি ক্লোন করুন
2. `.env.example` কপি করে `.env` তৈরি করুন
3. ডাটাবেস তৈরি করুন: `sql/database.sql` ইমপোর্ট করুন
4. লোকাল সার্ভারে চালান

## 📱 বৈশিষ্ট্য
✅ রেসপন্সিভ ডিজাইন
✅ ইউজার অথেন্টিকেশন
✅ কোর্স ম্যানেজমেন্ট
✅ প্রগতি ট্র্যাকিং
✅ এডমিন প্যানেল
✅ রিপোর্ট সিস্টেম
✅ মোবাইল ফ্রেন্ডলি

## 💻 টেকনোলজি
- **ব্যাকএন্ড**: PHP, MySQL
- **ফ্রন্টএন্ড**: HTML5, CSS3, JavaScript
- **নিরাপত্তা**: Password Hashing, SQL Injection Prevention

## 📝 লাইসেন্স
MIT License

## 👨‍💻 ডেভেলপার
johirxofficial
