# Windows Setup Guide for MiniEvent Reservation System

## 1. XAMPP Setup

### Start Required Services
1. Open XAMPP Control Panel
2. Click **Start** on **MySQL** service ✅
3. Apache is **NOT required** for `php -S` development server

### Check MySQL Port
1. In XAMPP Control Panel, click **Config** button next to MySQL
2. Select **my.ini**
3. Look for the line: `port=3306` or `port=3307`
4. Note the port number for database configuration

## 2. Database Setup

### Create Database
1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click **New** in the left sidebar
3. Enter database name: `mini_event`
4. Select collation: `utf8mb4_unicode_ci`
5. Click **Create**

### Create Tables
Execute this SQL in phpMyAdmin or import `database_setup.sql`:

```sql
-- Create events table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    seats INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL
);

-- Create reservations table
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Create admin table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);
```

## 3. Admin User Setup

### Create Admin Account
1. Open your browser and go to: `http://localhost:8000/seed_admin.php`
2. You should see a success message with credentials:
   - **Username**: `admin`
   - **Password**: `admin123`
3. The script will automatically create the admin user

## 4. Launch Development Server

### Start the Application
Open Command Prompt or PowerShell in the project directory and run:

```bash
php -S localhost:8000 -t public public/router.php
```

### Access the Application
Open your browser and go to: `http://localhost:8000/`

## 5. Test URLs Checklist

### Public Pages
- [ ] `http://localhost:8000/` - Event listing
- [ ] `http://localhost:8000/event?id=1` - Event details
- [ ] `http://localhost:8000/admin/login` - Admin login

### Admin Pages (after login)
- [ ] `http://localhost:8000/admin` - Dashboard
- [ ] `http://localhost:8000/admin/event/new` - Create event
- [ ] `http://localhost:8000/admin/event/edit?id=1` - Edit event
- [ ] `http://localhost:8000/admin/reservations?event_id=1` - View reservations
- [ ] `http://localhost:8000/admin/logout` - Logout

### Preview Pages (UI testing without backend)
- [ ] `http://localhost:8000/preview_list.php` - Event list preview
- [ ] `http://localhost:8000/preview_details.php` - Event details preview
- [ ] `http://localhost:8000/preview_admin_login.php` - Admin login preview
- [ ] `http://localhost:8000/preview_admin_dashboard.php` - Admin dashboard preview
- [ ] `http://localhost:8000/preview_admin_form_event.php` - Event form preview
- [ ] `http://localhost:8000/preview_admin_reservations.php` - Reservations preview

## 6. Troubleshooting

### Database Connection Issues
If you see PDO exceptions:
1. Ensure MySQL is running in XAMPP
2. Check if port is 3306 or 3307
3. Set environment variables if needed:
   ```cmd
   set DB_HOST=127.0.0.1
   set DB_PORT=3306
   set DB_NAME=mini_event
   set DB_USER=root
   set DB_PASS=
   ```

### Port Already in Use
If port 8000 is busy, try a different port:
```bash
php -S localhost:8001 -t public public/router.php
```

Then access: `http://localhost:8001/`