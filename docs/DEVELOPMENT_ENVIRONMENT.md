# SuiteCRM Development Environment Documentation

## Overview
This document describes the complete setup and configuration of the SuiteCRM 7.14.6 development environment on Windows with XAMPP.

## Environment Details

### System Configuration
- **Operating System:** Windows 10/11
- **Web Server:** XAMPP 8.2.12
- **PHP Version:** 8.2.12
- **Database:** MySQL/MariaDB (via XAMPP)
- **SuiteCRM Version:** 7.14.6

### Installation Summary
- **Web Access:** `http://localhost/suitecrm/`
- **Admin Panel:** `http://localhost/suitecrm/index.php?module=Administration`
- **Database Access:** `http://localhost/phpmyadmin`
- **Project Location:** `C:\xampp\htdocs\suitecrm\`

## Database Configuration

### Main Databases
- **Development Database:** `suitecrm`
  - Collation: `utf8mb4_general_ci`
  - User: `root`
  - Password: (empty - XAMPP default)
  
- **Test Database:** `suitecrm_test`
  - Collation: `utf8mb4_general_ci`
  - Used for automated testing

## Admin Access
- **Username:** `admin`
- **URL:** `http://localhost/suitecrm/`
- **Password:** [Set during installation]

## Development Dependencies

### Composer Packages (170 total)
Key development tools installed:
- **PHPUnit 9.5.27** - Unit testing framework
- **Codeception** - Acceptance/functional testing
- **Robo** - Build automation
- **PHP-CS-Fixer** - Code style formatting
- **PHPStan** - Static analysis
- **Symfony Components** - Framework libraries
- **Guzzle HTTP** - HTTP client
- **Monolog** - Logging framework

### Installation Status
✅ All system requirements met  
✅ PHP extensions enabled (gd, zip, curl, json, openssl, mbstring, xml, imap, zlib, pcre, mysqli)  
✅ File permissions configured  
✅ Database connections working  
✅ Composer dependencies installed  
✅ Testing framework configured  

## Testing Environment

### Available Test Suites
- **Unit Tests:** `tests/unit.suite.yml`
  - Individual function/class testing
  - Fast execution
  - No database dependencies for isolated tests

- **API Tests:** `tests/api.suite.yml`
  - REST/SOAP API endpoint testing
  - Database interactions
  - Authentication testing

- **Acceptance Tests:** `tests/acceptance.suite.yml`
  - Full browser automation
  - End-to-end workflows
  - User interface testing

- **Installation Tests:** `tests/install.suite.yml`
  - Installation process verification

### Test Configuration
- **Config File:** `tests/config.test.php`
- **PHPUnit Config:** `tests/phpunit.xml.dist`
- **Test Database:** `suitecrm_test`

### Running Tests
```cmd
# Navigate to project directory
cd C:\xampp\htdocs\suitecrm

# Run unit tests
vendor\bin\phpunit tests/unit/

# Run specific test file
vendor\bin\phpunit tests/unit/modules/

# Run with coverage (if configured)
vendor\bin\phpunit --coverage-html coverage/ tests/unit/
```

## Development Workflow

### Project Structure
```
C:\xampp\htdocs\suitecrm\
├── custom/                 # Custom development (MAIN WORK AREA)
│   ├── modules/           # Custom modules
│   ├── Extension/         # Extending existing modules
│   ├── include/           # Custom business logic
│   └── themes/            # Custom themes
├── modules/               # Core SuiteCRM modules (READ-ONLY)
├── tests/                 # Testing framework
├── vendor/                # Composer dependencies
└── docs/                  # Project documentation
```

### Custom Development Best Practices

#### 1. Use the `custom/` Directory
- **ALL custom code** goes in `custom/` directory
- Never modify core files directly
- Ensures upgrade compatibility
- Maintains clean separation of concerns

#### 2. Module Development
```
custom/modules/MyNewModule/
├── metadata/
├── language/
├── views/
├── controller.php
└── MyNewModule.php
```

#### 3. Extending Existing Modules
```
custom/Extension/modules/Accounts/
├── Ext/Vardefs/
├── Ext/Language/
└── Ext/Layoutdefs/
```

### Development Commands

#### Essential Operations
```cmd
# Start XAMPP services
# Use XAMPP Control Panel: Start Apache + MySQL

# Access SuiteCRM
http://localhost/suitecrm/

# Quick Repair & Rebuild (after changes)
# Admin > System > Repair > Quick Repair and Rebuild

# Clear cache
# Admin > System > Repair > Clear Tpls
```

#### Testing Commands
```cmd
# Run all unit tests
vendor\bin\phpunit tests/unit/

# Run specific test class
vendor\bin\phpunit tests/unit/modules/Accounts/

# Run tests with verbose output
vendor\bin\phpunit --verbose tests/unit/
```

## Performance Optimization

### Development Mode Settings
For faster development cycles, consider adding to `config_override.php`:

```php
<?php
// Development mode optimizations
$sugar_config['developer_mode'] = true;
$sugar_config['cache_dir'] = 'cache/';
$sugar_config['disable_count_query'] = true;
$sugar_config['save_query'] = 'populate_only';
$sugar_config['slow_query_time_msec'] = 1000;
```

### Database Performance
- Use indexes on custom fields with frequent searches
- Limit subpanel queries in development
- Use database query logging for optimization

## Troubleshooting

### Common Issues

#### 1. "Composer autoloader not found"
- **Solution:** Run `composer install` in project directory
- **Cause:** Missing vendor dependencies

#### 2. PHP extensions missing
- **Solution:** Edit `C:\xampp\php\php.ini`, uncomment required extensions
- **Required:** gd, zip, curl, json, openssl, mbstring, xml, imap, zlib, pcre, mysqli
- **Action:** Restart Apache after changes

#### 3. File permission errors
- **Solution:** Ensure write permissions on:
  - `cache/`
  - `custom/`
  - `modules/`
  - `upload/`
  - `config.php`

#### 4. Database connection issues
- **Check:** MySQL service running in XAMPP
- **Verify:** Database credentials in `config.php`
- **Test:** Access phpMyAdmin at `http://localhost/phpmyadmin`

#### 5. White screen/fatal errors
- **Enable:** PHP error reporting in `php.ini`
- **Check:** SuiteCRM logs in `suitecrm.log`
- **Verify:** File permissions and PHP memory limits

### Log Files
- **SuiteCRM Log:** `suitecrm.log`
- **Apache Error Log:** `C:\xampp\apache\logs\error.log`
- **PHP Error Log:** `C:\xampp\php\logs\php_error_log`

## Feature Development Process

### 1. Planning Phase
- Define feature requirements
- Design database schema changes
- Plan user interface modifications
- Write test cases

### 2. Development Phase
- Create custom modules in `custom/modules/`
- Extend existing modules via `custom/Extension/`
- Implement business logic in `custom/include/`
- Create unit tests in `tests/unit/`

### 3. Testing Phase
- Run unit tests: `vendor\bin\phpunit tests/unit/`
- Manual testing in browser
- Acceptance tests for UI workflows

### 4. Deployment Phase
- Quick Repair & Rebuild
- Clear cache/templates
- Verify functionality
- Document changes

## Next Steps

### Ready for Feature Development
Your environment is now ready for implementing the six planned features:

1. **Environment Status:** ✅ Complete
2. **Database:** ✅ Configured  
3. **Testing:** ✅ Ready
4. **Dependencies:** ✅ Installed
5. **Documentation:** ✅ Available

### Recommended First Steps
1. Create a simple test module to verify development workflow
2. Set up IDE/editor with PHP and SuiteCRM extensions
3. Review SuiteCRM development documentation
4. Plan your first feature implementation

---

**Environment Setup Completed:** Ready for feature development and testing! 🚀 