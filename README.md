# Prestige Hotel Management System

Hotel booking and reservation platform for Prestige Hotel in Cape Coast, Ghana.

Built on QloApps - a comprehensive hotel management system.

## Features
- Room booking and reservations
- Customer management
- Online booking system
- Payment processing
- Room availability management

## Setup Instructions

### Database Configuration

The database configuration file (`config/settings.inc.php`) is excluded from git for security reasons. To set up the application:

1. Copy the template file:
   ```bash
   cp config/settings.inc.php.sample config/settings.inc.php
   ```

2. Edit `config/settings.inc.php` and update with your database credentials:
   - `_DB_SERVER_`: Your database server hostname
   - `_DB_NAME_`: Your database name
   - `_DB_USER_`: Your database username
   - `_DB_PASSWD_`: Your database password
   - Other security keys as needed

3. Ensure the file has proper permissions (not publicly accessible)

### Important Notes

- Never commit `config/settings.inc.php` to version control
- Keep your database credentials secure
- The application requires PHP with MySQL/MySQLi support

## Location
Mooneye Street, Amamoma, Cape Coast, Ghana

## Contact
- Email: prestigehotelcc@gmail.com
- Phone: 0205328339
