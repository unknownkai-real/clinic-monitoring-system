# Clinic Monitoring System

A web-based Clinic Monitoring System built with **PHP**, **MySQL**, **Bootstrap 5**, **JavaScript/AJAX**, and designed to run on **XAMPP**.

## System Link (Local)
After setup, open:

- **Login Page:** `http://localhost/clinic-monitoring-system/app/auth/login.php`
- **Dashboard:** `http://localhost/clinic-monitoring-system/app/index.php`

> If your Apache document root points elsewhere, copy this repository into your XAMPP `htdocs` directory and adjust the URL path accordingly.


### If your folder name is different
If your project folder is named `clinic-monitoring-system-main`, use:
- `http://localhost/clinic-monitoring-system-main/app/auth/login.php`
- `http://localhost/clinic-monitoring-system-main/app/index.php`

## Default Admin Account
- **Username:** `admin`
- **Password:** `admin123` *(update immediately after first login)*

## Features Implemented
- Session-based authentication (login/logout)
- Role field support (`admin`, `nurse`, `doctor`, `staff`)
- Dashboard metrics and monthly visits chart
- AJAX-based CRUD API with prepared statements
- Soft delete support (`deleted_at`)
- Modules:
  - Students
  - Employees
  - Inventory (Medicines)
  - Admissions
  - Consultations
  - Borrowings
  - First Aid
- MySQL schema with relationships, indexes, and activity log table

## Tech Stack
- PHP 8+
- MySQL 8+ / MariaDB
- Bootstrap 5
- jQuery + DataTables
- Chart.js

## XAMPP Setup Guide
1. Install and start **Apache** and **MySQL** from XAMPP.
2. Place the project folder in:
   - `C:\xampp\htdocs\clinic-monitoring-system` (Windows)
   - `/Applications/XAMPP/htdocs/clinic-monitoring-system` (macOS)
3. Create a database and import SQL:
   - Open `http://localhost/phpmyadmin`
   - Create database: `clinic_monitoring`
   - Import file: `app/database/clinic_monitoring.sql`
4. Verify DB connection in `app/config/db.php`:
   - host: `localhost`
   - db: `clinic_monitoring`
   - user: `root`
   - pass: `` (default XAMPP)
5. Open the login page and sign in.

## Project Structure
```
app/
  api/               # AJAX endpoints
  auth/              # login/logout pages
  config/            # database connection
  database/          # SQL schema
  includes/          # reusable header/sidebar/footer/auth middleware
  modules/           # module pages
  index.php          # dashboard
```

## Security Notes
- Uses PDO prepared statements for CRUD operations.
- Protected routes via session middleware.
- Sensitive fields (e.g., medical notes) are not displayed in default table columns.

## Basic Validation / Checks
Run syntax checks:

```bash
find app -name '*.php' -print0 | xargs -0 -n1 php -l
```

## Production Hardening Recommendations
Before production deployment, add:
- HTTPS and secure cookie/session settings
- CSRF tokens on all forms and state-changing requests
- Password reset / change flow and strong password policy
- Full audit logging in every CRUD path
- Granular RBAC checks per action/module
- Server-side pagination/filtering for large datasets
- File upload validation and malware scanning

## License
For institutional/internal use. Add your preferred license before public release.
