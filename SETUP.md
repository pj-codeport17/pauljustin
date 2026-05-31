# AniTrack — Laravel Setup Guide

## Requirements
- XAMPP (PHP 8.2+, MySQL, Apache)
- Composer (optional — vendor folder already included)

## Steps

### 1. Place the project
Copy the `Laravel_Camaclang` folder to:
```
C:\xampp\htdocs\Laravel_Camaclang
```

### 2. Create the database
Open phpMyAdmin → New → create database named:
```
db_laravel
```

### 3. Run migrations + seed admin
Open **XAMPP Shell** or terminal, go to the project folder:
```
cd C:\xampp\htdocs\Laravel_Camaclang
php artisan migrate
php artisan db:seed
```

### 4. Open the app
```
http://localhost/Laravel_Camaclang/public
```

### 5. Login as Admin
- Email: `admin@anitrack.com`
- Password: `admin123`

### 6. Make storage link (for avatar uploads)
```
php artisan storage:link
```

## Roles
| Role | Access |
|------|--------|
| Admin | Dashboard (stats+charts), Profile, Users Management |
| User  | Dashboard, My Anime (CRUD), Profile, Contact |
