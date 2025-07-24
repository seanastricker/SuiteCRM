# SuiteCRM 7.14.6 Development Environment Setup Guide

## 📋 System Requirements

**Current Version**: SuiteCRM 7.14.6 (November 2024)

### Required Components:
- **PHP**: 7.4+ (recommended: 8.1 or 8.2)
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Web Server**: Apache 2.4+ or Nginx
- **Memory**: Minimum 256MB (recommended: 512MB+)
- **Storage**: 2GB+ free space

### Required PHP Extensions:
- `curl` - For external API calls
- `gd` - For image processing
- `json` - For data handling
- `openssl` - For security
- `zip` - For file compression
- `mbstring` - For string handling
- `xml` - For XML parsing
- `imap` - For email functionality
- `zlib` - For compression
- `pcre` - For regular expressions
- `mysqli` - For MySQL database

---

## 🚀 Setup Options

### Option 1: XAMPP (Recommended for Quick Start)

1. **Download XAMPP**
   - Go to: https://www.apachefriends.org/download.html
   - Download XAMPP with PHP 8.1 or 8.2
   - Install to `C:\xampp`

2. **Configure XAMPP**
   ```bash
   # Start XAMPP Control Panel
   # Enable Apache and MySQL services
   ```

3. **Configure PHP**
   - Edit `C:\xampp\php\php.ini`
   - Ensure these extensions are enabled:
   ```ini
   extension=curl
   extension=gd
   extension=mbstring
   extension=mysqli
   extension=openssl
   extension=zip
   extension=imap
   extension=xml
   ```

4. **Set PHP Memory Limits**
   ```ini
   memory_limit = 512M
   upload_max_filesize = 20M
   post_max_size = 20M
   max_execution_time = 300
   ```

### Option 2: Docker (Recommended for Advanced Users)

Create a `docker-compose.yml` in your project root:

```yaml
version: '3.8'
services:
  web:
    image: php:8.1-apache
    ports:
      - "80:80"
    volumes:
      - .:/var/www/html
    depends_on:
      - db
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: suitecrm
      MYSQL_USER: suitecrm
      MYSQL_PASSWORD: suitecrm
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql

  db_test:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: suitecrm_test
      MYSQL_USER: suitecrm_test
      MYSQL_PASSWORD: suitecrm_test
    ports:
      - "3307:3306"

volumes:
  db_data:
```

---

## 📂 Project Setup

### Step 1: Verify System Check
Navigate to your SuiteCRM folder and ensure file permissions:

```bash
# For Windows with XAMPP
# Copy SuiteCRM files to C:\xampp\htdocs\suitecrm\

# Ensure these directories are writable:
# - cache/
# - custom/
# - modules/
# - upload/
# - config.php (will be created during install)
```

### Step 2: Install Dependencies

```bash
# Install Composer if not already installed
# Download from: https://getcomposer.org/download/

# Navigate to SuiteCRM directory
cd /path/to/suitecrm

# Install PHP dependencies
composer install

# Compile legacy theme (optional but recommended)
./vendor/bin/pscss -s compressed ./public/legacy/themes/suite8/css/Dawn/style.scss > ./public/legacy/themes/suite8/css/Dawn/style.css
```

### Step 3: Database Setup

```sql
-- Create main database
CREATE DATABASE suitecrm CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Create test database
CREATE DATABASE suitecrm_test CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Create user (optional - can use root for development)
CREATE USER 'suitecrm'@'localhost' IDENTIFIED BY 'suitecrm';
GRANT ALL PRIVILEGES ON suitecrm.* TO 'suitecrm'@'localhost';
GRANT ALL PRIVILEGES ON suitecrm_test.* TO 'suitecrm'@'localhost';
FLUSH PRIVILEGES;
```

---

## 🔧 Installation Process

### Step 1: Web-Based Installation

1. **Start your web server and database**
2. **Navigate to**: `http://localhost/suitecrm/install.php`
3. **Follow the installation wizard**:
   - Accept license
   - System requirements check
   - Database configuration:
     - Host: `localhost`
     - Database: `suitecrm`
     - Username: `suitecrm` (or `root`)
     - Password: `suitecrm` (or your root password)
   - Admin user setup
   - Site configuration

### Step 2: Post-Installation

```bash
# Set proper file permissions (Linux/Mac)
find . -type d -not -perm 2755 -exec chmod 2755 {} \;
find . -type f -not -perm 0644 -exec chmod 0644 {} \;

# For Windows, ensure IIS_IUSRS or Apache user has full control over:
# - cache/
# - custom/
# - modules/
# - upload/
# - config.php
```

---

## 🧪 Testing Environment Setup

### Configure Testing with Robo

```bash
# Configure test environment
./vendor/bin/robo configureTests

# This will prompt for:
# - Database driver: MYSQL
# - Database host: localhost
# - Database name: suitecrm_test
# - Database user: suitecrm
# - Database password: suitecrm
# - Instance URL: http://localhost/suitecrm
# - Admin username: admin
# - Admin password: admin1
```

### Install ChromeDriver for Acceptance Tests

```bash
# Download ChromeDriver
./vendor/bin/robo chromedriver:install

# Or manually download from:
# https://chromedriver.chromium.org/
```

### Running Tests

```bash
# Run unit tests
./vendor/bin/phpunit --configuration ./tests/phpunit.xml.dist ./tests/unit/phpunit

# Run API tests
./vendor/bin/codecept run tests/api/V8/ -f

# Run acceptance tests
./vendor/bin/codecept run acceptance -f

# Run specific test suite
./vendor/bin/codecept run install --env chrome
```

---

## 🔨 Development Workflow

### File Structure for Custom Development

```
SuiteCRM/
├── custom/                     # Your customizations go here
│   ├── Extension/             # Framework extensions
│   ├── modules/               # Module customizations
│   ├── include/               # Custom includes
│   └── application/           # Application extensions
├── modules/                   # Core modules (don't modify directly)
├── include/                   # Core includes
└── tests/                     # Test files
```

### Creating Custom Modules

1. **Use Module Builder** (recommended for new modules)
   - Admin Panel → Developer Tools → Module Builder

2. **Manual Creation** (for complex customizations)
   - Create in `custom/modules/YourModule/`
   - Follow SuiteCRM naming conventions

### Testing Your Changes

```bash
# Quick repair and rebuild (after making changes)
# Admin Panel → Repair → Quick Repair and Rebuild

# Or via command line
php -r "require_once('include/utils.php'); require_once('modules/Administration/QuickRepairAndRebuild.php'); \$repair = new RepairAndClear(); \$repair->repairAndClearAll(['clearAll'], ['All Modules'], true, false);"
```

---

## 📊 Performance Optimization

### Development Settings

Add to `config_override.php`:

```php
<?php
// Development settings
$sugar_config['developer_mode'] = true;
$sugar_config['logger']['level'] = 'debug';
$sugar_config['logger']['file']['name'] = 'suitecrm';
$sugar_config['cache_dir'] = 'cache/';

// Disable caching during development
$sugar_config['external_cache_disabled'] = true;
$sugar_config['external_cache_disabled_apc'] = true;
$sugar_config['external_cache_disabled_memcache'] = true;
$sugar_config['external_cache_disabled_smash'] = true;
```

### Database Optimization

```sql
-- Ensure proper MySQL settings for development
SET GLOBAL innodb_buffer_pool_size = 256M;
SET GLOBAL max_connections = 200;
SET GLOBAL query_cache_size = 32M;
```

---

## 🚨 Troubleshooting

### Common Issues:

1. **Permission Denied Errors**
   - Ensure web server user has write access to cache/, custom/, modules/, upload/

2. **PHP Extension Missing**
   - Check with: `php -m | grep extension_name`
   - Enable in php.ini and restart web server

3. **Memory Limit Exceeded**
   - Increase `memory_limit` in php.ini to 512M or higher

4. **Database Connection Failed**
   - Verify MySQL/MariaDB is running
   - Check credentials and database exists
   - Ensure user has proper privileges

### Debug Mode:

```php
// Add to config_override.php for debugging
$sugar_config['logger']['level'] = 'debug';
$sugar_config['dump_slow_queries'] = true;
$sugar_config['import_max_execution_time'] = 3600;
```

---

## ✅ Verification Checklist

- [ ] PHP 7.4+ installed with all required extensions
- [ ] MySQL/MariaDB running with test database
- [ ] SuiteCRM installed and accessible via web browser
- [ ] Admin user can log in successfully
- [ ] Composer dependencies installed
- [ ] Test environment configured
- [ ] Basic tests passing
- [ ] File permissions properly set
- [ ] Development settings configured

---

## 🎯 Next Steps

After completing this setup, you'll be ready to:

1. **Explore the codebase** and understand module structure
2. **Create your first custom module** using Module Builder
3. **Implement your 6 new features** with proper testing
4. **Use the testing framework** to verify functionality
5. **Follow SuiteCRM best practices** for maintainable code

Ready to proceed with the setup? Let me know which option you'd prefer and I'll guide you through the specific steps! 