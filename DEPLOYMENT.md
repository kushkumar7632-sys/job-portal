# JobPortal Production Deployment Guide & Operations Manual

This guide outlines the complete operational procedures, server configuration, backup routines, and maintenance tasks for deploying the **JobPortal** application (Laravel 12, PHP 8.2+, MySQL, Vite) to production environments.

---

## 1. System Requirements

### Operating System & Core Runtimes
- **OS:** Ubuntu 22.04 LTS / 24.04 LTS, Debian 12, or AlmaLinux 9
- **PHP:** PHP 8.2 or PHP 8.3
- **Web Server:** Nginx (recommended) or Apache 2.4+
- **Database:** MySQL 8.0+ or MariaDB 10.11+
- **Node.js:** Node.js 18+ or 20+ (for building production assets during CI/CD)
- **Composer:** Composer 2.7+

### Required PHP Extensions
Ensure the following PHP extensions are installed and enabled (`php -m`):
```bash
sudo apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-curl php8.2-bcmath php8.2-fileinfo php8.2-zip php8.2-intl
```

---

## 2. Directory Permissions

The web server process (`www-data` on Ubuntu/Debian, `nginx`/`apache` on RHEL) requires write permissions to the `storage/` and `bootstrap/cache/` directories:

```bash
# Set ownership
sudo chown -R www-data:www-data /var/www/job-portal
sudo find /var/www/job-portal -type f -exec chmod 644 {} \;
sudo find /var/www/job-portal -type d -exec chmod 755 {} \;

# Writable directories
sudo chmod -R 775 /var/www/job-portal/storage
sudo chmod -R 775 /var/www/job-portal/bootstrap/cache
```

Ensure private resume storage directory exists:
```bash
mkdir -p /var/www/job-portal/storage/app/private/resumes
sudo chown -R www-data:www-data /var/www/job-portal/storage/app/private
```

---

## 3. Production Environment Configuration (`.env`)

Copy `.env.example` to `.env` on the production server (never commit `.env` to Git):

```ini
APP_NAME="JobPortal"
APP_ENV=production
APP_KEY=base64:... # Generate using `php artisan key:generate`
APP_DEBUG=false
APP_URL=https://jobs.example.com

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobportal_prod
DB_USERNAME=jobportal_user
DB_PASSWORD=YourStrongDatabasePasswordHere

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

FILESYSTEM_DISK=local

# Initial Admin Seeding (run once during initial setup)
INITIAL_ADMIN_NAME="System Administrator"
INITIAL_ADMIN_EMAIL=admin@example.com
INITIAL_ADMIN_PASSWORD=YourSecureAdminPassword123!
```

---

## 4. Web Server Configurations

### A. Nginx Configuration (`/etc/nginx/sites-available/job-portal.conf`)

> [!IMPORTANT]
> The `root` directive MUST point directly to `/public`, NEVER to the repository root. This prevents `.env`, `composer.json`, and private storage from being accessed over HTTP.

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name jobs.example.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name jobs.example.com;

    # Document Root (Strictly pointed to /public)
    root /var/www/job-portal/public;
    index index.php index.html;

    # SSL Certificates (managed via Certbot Let's Encrypt)
    ssl_certificate /etc/letsencrypt/live/jobs.example.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/jobs.example.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    charset utf-8;
    client_max_body_size 10M;

    # Laravel Front Controller
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Static Assets Caching
    location ~* \.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
        access_log off;
    }

    # PHP-FPM Processor
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Block access to hidden files (.env, .git, etc.)
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### B. Apache VirtualHost Configuration (`/etc/apache2/sites-available/job-portal.conf`)

```apache
<VirtualHost *:80>
    ServerName jobs.example.com
    Redirect permanent / https://jobs.example.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName jobs.example.com
    DocumentRoot /var/www/job-portal/public

    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/jobs.example.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/jobs.example.com/privkey.pem

    <Directory /var/www/job-portal/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Block hidden files and sensitive directories
    <DirectoryMatch "/\.(?!well-known)">
        Require all denied
    </DirectoryMatch>

    ErrorLog ${APACHE_LOG_DIR}/jobportal_error.log
    CustomLog ${APACHE_LOG_DIR}/jobportal_access.log combined
</VirtualHost>
```

### C. Shared Hosting (cPanel / Plesk) Deployment Rules
1. Never place project root inside `public_html`.
2. Upload the Laravel project files to a private sibling folder: `/home/username/job-portal/`.
3. Move the contents of `job-portal/public/` into `/home/username/public_html/`.
4. In `/home/username/public_html/index.php`, adjust paths to autoload and bootstrap:
   ```php
   require __DIR__.'/../job-portal/vendor/autoload.php';
   $app = require_once __DIR__.'/../job-portal/bootstrap/app.php';
   ```
5. Ensure `.env` remains in `/home/username/job-portal/.env` completely outside `public_html`.

---

## 5. Deployment Step-by-Step Runbook

Run these commands during each deployment:

```bash
# 1. Enter project directory
cd /var/www/job-portal

# 2. Put application into maintenance mode
php artisan down --secret="deployment-bypass-token" --render="errors::503"

# 3. Pull latest code
git pull origin main

# 4. Install production PHP dependencies (no dev dependencies)
composer install --no-dev --optimize-autoloader --no-interaction

# 5. Build production frontend assets
npm ci
npm run build

# 6. Run database migrations safely
php artisan migrate --force

# 7. Seed initial administrator (only on first setup; safely no-ops if admin exists)
php artisan db:seed --class=AdminSeeder --force

# 8. Optimize and cache configuration, routes, and views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Restart queue workers (if background queues are used)
# php artisan queue:restart

# 10. Reload PHP-FPM
sudo systemctl reload php8.2-fpm

# 11. Bring application back online
php artisan up
```

---

## 6. Backup & Disaster Recovery Runbook

### A. Database Backup
Create `/usr/local/bin/backup-jobportal-db.sh`:
```bash
#!/usr/bin/env bash
set -eo pipefail

BACKUP_DIR="/var/backups/jobportal/database"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
DB_NAME="jobportal_prod"
DB_USER="jobportal_user"
# Store password in ~/.my.cnf for security, or pass via config

mkdir -p "$BACKUP_DIR"

mysqldump --defaults-extra-file=/etc/mysql/jobportal-backup.cnf \
    --single-transaction \
    --quick \
    --routines \
    --triggers \
    "$DB_NAME" | gzip > "$BACKUP_DIR/jobportal_db_${TIMESTAMP}.sql.gz"

# Retain backups for 14 days
find "$BACKUP_DIR" -type f -name "*.sql.gz" -mtime +14 -delete
```

### B. Resumes Backup
Resumes are stored privately in `storage/app/private/resumes`.

Create `/usr/local/bin/backup-jobportal-resumes.sh`:
```bash
#!/usr/bin/env bash
set -eo pipefail

BACKUP_DIR="/var/backups/jobportal/resumes"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
RESUMES_DIR="/var/www/job-portal/storage/app/private/resumes"

mkdir -p "$BACKUP_DIR"

if [ -d "$RESUMES_DIR" ]; then
    tar -czf "$BACKUP_DIR/resumes_${TIMESTAMP}.tar.gz" -C "$RESUMES_DIR" .
    # Retain backups for 30 days
    find "$BACKUP_DIR" -type f -name "*.tar.gz" -mtime +30 -delete
fi
```

### C. Automated Cron Schedule (`/etc/cron.d/jobportal-backups`)
```cron
# Daily database backup at 02:00 AM
0 2 * * * root /usr/local/bin/backup-jobportal-db.sh > /dev/null 2>&1

# Daily resumes backup at 02:30 AM
30 2 * * * root /usr/local/bin/backup-jobportal-resumes.sh > /dev/null 2>&1
```

### D. Deployment Rollback Procedure
If an issue occurs immediately after a deployment:

1. Put application into maintenance mode:
   ```bash
   php artisan down
   ```
2. Rollback git commit to previously known stable tag/hash:
   ```bash
   git checkout <stable-commit-hash>
   ```
3. Re-install vendor dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
4. Re-compile frontend assets:
   ```bash
   npm run build
   ```
5. Clear and re-cache:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
6. Reload PHP-FPM and exit maintenance:
   ```bash
   sudo systemctl reload php8.2-fpm
   php artisan up
   ```
