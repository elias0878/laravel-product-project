# Laravel Product Management App - Render Deployment Guide

## معلومات التطبيق
تطبيق لارافيل لإدارة المنتجات مع دعم اللغة العربية والإنجليزية.

## متطلبات التشغيل
- PHP 8.2
- Laravel 12
- قاعدة بيانات SQLite (للتطوير) أو PostgreSQL (للإنتاج)
- دعم Docker

## طريقة النشر على Render.com (الخطوات)

### الخطوة 1: إنشاء حساب
1. اذهب إلى [Render.com](https://render.com)
2. سجل دخول باستخدام حساب GitHub

### الخطوة 2: ربط المستودع
1. اضغط على **"New +"** > **"Web Service"**
2. اختر **"Configure GitHub"** واسمح بالوصول
3. ابحث عن مستودع: **elias0878/laravel-product-project**

### الخطوة 3: إعدادات الخدمة
```
Name: laravel-product-app
Root Directory: /
Runtime: Docker
Build Command: (فارغ)
Start Command: (فارغ)
```

### الخطوة 4: إضافة المتغيرات البيئية
في قسم **Environment Variables**، أضف:
```
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=stderr
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
```

### الخطوة 5: إعدادات Dockerfile
```
Dockerfile Path: Dockerfile
Docker Context: .
```

### الخطوة 6: إنشاء الخدمة
- اختر الخطة المجانية **Free**
- اضغط **"Create Web Service"**
- انتظر حتى يكتمل البناء والنشر

## بعد النشر
- رابط التطبيق: س يظهر بعد البناء
- للتحقق: اذهب إلى `/ar/products` أو `/en/products`

## الملفات الرئيسية
- `Dockerfile`: إعداد Docker للإنتاج
- `docker-entrypoint.sh`: سكريبت بدء التطبيق
- `.env.example`: مثال متغيرات البيئة

## قاعدة البيانات
يستخدم التطبيق SQLite افتراضياً. للنشر الإنتاجي، أنشئ PostgreSQL Database على Render وأضف:
```
DB_CONNECTION=pgsql
DB_HOST=...
DB_PORT=...
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

## الدعم
للأسئلة أو المشاكل، راجع توثيق Render أو Laravel.
