# Database Migrations

This folder contains the SQL migration files for setting up the database structure.

## How to Run Migrations

1. First, create the database:
```sql
CREATE DATABASE demo_crystalcrm;
```

2. Then, you can run the migrations in order using one of these methods:

### Method 1: Using MySQL Command Line
```bash
mysql -u root -p demo_crystalcrm < 001_create_owner_table.sql
mysql -u root -p demo_crystalcrm < 002_create_applications_table.sql
```

### Method 2: Using phpMyAdmin
1. Open phpMyAdmin
2. Select the `demo_crystalcrm` database
3. Go to the "Import" tab
4. Select and import each SQL file in order (001 first, then 002)

## Default Admin Credentials
- Email: admin@gmail.com
- Password: 12345

## Database Configuration
Make sure your database configuration in `config/database.php` matches your local setup:
- Host: localhost
- Database: demo_crystalcrm
- Username: root
- Password: (your password)
- Port: 3306 